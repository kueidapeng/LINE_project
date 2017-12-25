<?php 
require_once '../vendor/autoload.php';

if (file_exists(__DIR__.'/.env')){
	$dotenv = new Dotenv\Dotenv(__DIR__);	
	$dotenv->load();
}

$ffmpeg = \FFMpeg\FFMpeg::create(array(
    'ffmpeg.binaries'  => getenv('ffmpeg_path'),
    'ffprobe.binaries' => getenv('ffprobe_path'),
));
$audio = $ffmpeg->open('voice3.aac');

$format = new FFMpeg\Format\Audio\Flac();
$format->on('progress', function ($audio, $format, $percentage) {
    echo "$percentage % transcoded";
});
$format->setAudioChannels(1);
$audio->save($format, 'voice3.flac');

 	$bot = new LINE\LINEBot(
  		new LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('curlHTTPClient')),
  		['channelSecret' => getenv('channelSecret')]
	);
 
	$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
	$body = file_get_contents("php://input");
	$redis= new App\event\RedisHandler;				//create RedisHandler object

	//error_log("Signature: ".$signature);

    $events = $bot->parseEventRequest($body, $signature);
	

    foreach ($events as $event){
	
		$reply_token = $event->getReplyToken();
		$user_id=$event->getUserId();

		//follow event 
        if ($event instanceof \LINE\LINEBot\Event\FollowEvent) { 

			include('event/follow_event/bot_follow_event.php');

		}
		
		//follow event 
        if ($event instanceof \LINE\LINEBot\Event\UnfollowEvent) { 
	 
			include('event/follow_event/bot_unfollow_event.php');
			
		}

		
		//join group event
        if ($event instanceof \LINE\LINEBot\Event\JoinEvent) { 

			include('event/join_event/bot_join_event.php');			

 
        }
 
		//text event 
        if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
			$getText = $event->getText();

			$user_status=$redis->checkStatus($user_id); //user status

			switch ($user_status) {
				case 'map_key':
				$getText = '關鍵字：'.$getText;
				break;
				case 'map_cat':
				$getText = '類別：'.$getText;
				break;				
			}

			$array = [
				"座標優惠搜尋" => "bot_map_search",
				"類別搜尋" => "bot_map_search_cat",
				"關鍵字搜尋" => "bot_map_search_key",
				"卡好用服務" => "bot_imagemap",
				preg_match ("/\類別：/i", $getText) == 1 ? $getText : "" => "bot_category",
				preg_match ("/\關鍵字：/i", $getText) == 1 ? $getText : "" => "bot_keyword",
			];			

			if(isset($array[$getText])){
			include('event/message_event/'.$array[$getText].'.php');
			}else{ 
			   $result= find_synonym(urlencode($getText));
			   if($result!=='bot_imagemap')
				include('event/message_event/no_event.php');
			   else{
				include('event/message_event/bot_imagemap.php');  
			   }
			} 
			
        }

		//location event 		
		if ($event instanceof \LINE\LINEBot\Event\MessageEvent\LocationMessage) {

			include('event/location_event/bot_location_event.php');

		}
		
		if ($event instanceof \LINE\LINEBot\Event\PostbackEvent) {

			include('event/postback_event/bot_postback_event.php');			


		}		
	
    }

	//emoji unicode
	function emoji($ID){
 		$bin = hex2bin(str_repeat('0', 8 - strlen($ID)) . $ID);
		$emoticon =  mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
		return $emoticon;
	}
	//Dialogflow find synonym
	function find_synonym($getText){
		$ch = curl_init();
		// set url
		curl_setopt($ch, CURLOPT_URL, "https://api.dialogflow.com/v1/query?v=20170712&query='.$getText.'&lang=en&sessionId=" .trim(getenv('sessionID')));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer '.trim(getenv('CLIENT_ACCESS_TOKEN'))));
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// $output contains the output string
		$output = curl_exec($ch);
		// close curl resource to free up system resources
		curl_close($ch);
	  return  json_decode($output)->result->fulfillment->speech;
   }

 ?>