<?php 
require_once '../vendor/autoload.php';

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
		
		//$result_id=$redis->checkUserId($user_id);
		//$redis->addUserId($user_id);
		//$result_id=$redis->checkUserId($user_id);
		//$redis->deleteUserId($user_id);
		//$result_id=$redis->checkUserId($user_id);
	 	//$result_Location=$redis->checkLocation($user_id);
		// $redis->addUserLocation($user_id,$latitude,$longitude);

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
 
			$array = [
				"安安" => "bot_event1",
				"掰掰" => "bot_event2",
				"顆顆" => "bot_event3",
				"carousel" => "bot_carousel",
				"news" => "bot_news",	
				"confirm" => "bot_confirm",				
				"video" => "bot_video",
				//==================================
				"座標優惠收尋" => "bot_map_search",
				"卡好用服務" => "bot_imagemap",
				preg_match ("/\類別：/i", $getText) == 1 ? $getText : "" => "bot_category",			
			];			

			if(isset($array[$getText])){
			include('event/message_event/'.$array[$getText].'.php');
			}else{ 
			include('event/message_event/no_event.php');
			} 
			
        }

		//location event 		
		if ($event instanceof \LINE\LINEBot\Event\MessageEvent\LocationMessage) {

			if($redis->checkLocation($user_id)==0){ // location add
				$result_Location=$redis->addUserLocation($user_id,$event->getLatitude(),$event->getLongitude());
				
				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("所在座標已新增".emoji('10008F')); //文字
				$response =  $bot->replyMessage($reply_token, $textMessageBuilder);
			}else{ // location update	
				$result_Location=$redis->updateUserLocation($user_id,$event->getLatitude(),$event->getLongitude());

				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("所在座標已更新".emoji('10008F')); //文字
				$response =  $bot->replyMessage($reply_token, $textMessageBuilder);
			}
 

		}
		
		if ($event instanceof \LINE\LINEBot\Event\PostbackEvent) {
			
			$getText = $event->getPostbackData();
			
			if ($getText) {
				parse_str($getText, $data);
				if (isset($data["ans"])) {
					
					$page = $data["ans"];
					$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($page);  
					$bot->replyMessage($reply_token, $textMessageBuilder);					

				}
			}

		}		
	
    }

	//emoji unicode
	function emoji($ID){
 
	$bin = hex2bin(str_repeat('0', 8 - strlen($ID)) . $ID);
	$emoticon =  mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
	return $emoticon;
	
	}
	
 ?>