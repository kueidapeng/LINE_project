<?php 
require_once '../vendor/autoload.php';
use Google\Cloud\Speech\SpeechClient;
  
 
 	if (file_exists(__DIR__.'/.env')){
		$dotenv = new Dotenv\Dotenv(__DIR__);	
		$dotenv->load();
	}
 
 
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
				"安安" => "bot_event1",
				"座標優惠搜尋" => "bot_map_search",
				"類別搜尋" => "bot_map_search_cat",
				"關鍵字搜尋" => "bot_map_search_key",
				"卡好用服務" => "bot_imagemap",
				//preg_match ("/\類別：/i", $getText) == 1 ? $getText : "" => "bot_category",
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
		
		if ($event instanceof \LINE\LINEBot\Event\MessageEvent\ImageMessage) {
			$contentId = $event->getMessageId();
			$audio = $bot->getMessageContent($contentId)->getRawBody();
		 
			$data=date('Y-h-m-h-i-s');
			$soundfile =  file_put_contents('./file/'.$data.'.jpg', $audio);
			$image="http://355d5995.ngrok.io/line_bot/file/".$data.".jpg";
//$image="https://samples.clarifai.com/metro-north.jpg"

			$post_data = [
				"inputs" => [
				  [		
					  "data" =>
				  [
					"image" => 
					["url" => $image,]
			 
				  ]
				  ]
				]
			  ]; 
			
			
			$ch = curl_init("https://api.clarifai.com/v2/models/aaa03c23b3724a16a56b629203edc62c/outputs");
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Authorization: Key '."d0c7cb9e47f44f558eb01060b99cb752"
				//'Authorization: Bearer '. TOKEN
			));
			$result = curl_exec($ch);
			$json = json_decode($result, true);
			$message="在這圖片裡面有:\n\t";
			for($i=0;$i<count($json['outputs'][0]['data']['concepts']);$i++){
				 
				$message=$message.$json['outputs'][0]['data']['concepts'][$i]['name']." 可能:".$json['outputs'][0]['data']['concepts'][$i]['value']."%\n\t";
			}	

			$reply_token = $event->getReplyToken();
			$bot->replyText($reply_token, $message);

		}

	 if ($event instanceof \LINE\LINEBot\Event\MessageEvent\AudioMessage) {
			
				  $contentId = $event->getMessageId();
				  $audio = $bot->getMessageContent($contentId)->getRawBody();
				  $data=date('Y-h-m-h-i-s');
				  $soundfile =  file_put_contents('./tmp/'.$data.'.aac', $audio);

				  $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("正在分析語音請稍後..."); //文字
				  $response = $bot->pushMessage($user_id, $textMessageBuilder); //message push	

				  $ffmpeg = \FFMpeg\FFMpeg::create(array(
					'ffmpeg.binaries'  => getenv('ffmpeg_path'),
					'ffprobe.binaries' => getenv('ffprobe_path'),
				));
				
				$audio = $ffmpeg->open('./tmp/'.$data.'.aac');				

				$format = new FFMpeg\Format\Audio\Flac();
				$format->on('progress', function ($audio, $format, $percentage) {
					echo "$percentage % transcoded";
				});
				$format->setAudioChannels(1);
				$audio->save($format, './tmp/'.$data.'.flac');
 
				$speech_json=[
					"type"=> getenv('type'),
					"project_id"=> getenv('project_id'),
					"private_key_id"=> getenv('private_key_id'),
					"private_key"=> str_replace('|', "\n",getenv('private_key')),
					"client_email"=> getenv('client_email'),
					"client_id"=> getenv('client_id'),	
					"auth_uri"=> getenv('auth_uri'),
					"token_uri"=> getenv('token_uri'),
					"auth_provider_x509_cert_url"=> getenv('auth_provider_x509_cert_url'),
					"client_x509_cert_url"=> getenv('client_x509_cert_url'),
				];
				
				$speech = new SpeechClient([
					'projectId' => 'speechtotext-189807',
					 'languageCode' => 'cmn-Hant-TW',
					'keyFile' => $speech_json
				 
				]);
				
				// Recognize the speech in an audio file.

				$results = $speech->recognize(
					fopen('./tmp/'.$data.'.flac', 'r')
				);
				 $aaa="";
				foreach ($results as $result) {
 
					$reply_token = $event->getReplyToken();
					$bot->replyText($reply_token, $result->topAlternative()['transcript']);
				}

				//Delete file
				unlink('./tmp/'.$data.'.aac');
				unlink('./tmp/'.$data.'.flac');
				 
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