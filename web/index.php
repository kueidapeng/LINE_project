<?php 

require_once '../vendor/autoload.php';

if (file_exists(__DIR__.'/.env')){
	$dotenv = new Dotenv\Dotenv(__DIR__);	
	$dotenv->load();
}

 $bot = new \LINE\LINEBot(
  new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('curlHTTPClient')),
  ['channelSecret' => getenv('channelSecret')]
);
 
$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$body = file_get_contents("php://input");

error_log("Signature: ".$signature);

    $events = $bot->parseEventRequest($body, $signature);
	
error_log("events: ".$events);
    foreach ($events as $event){
		//call push message 
		// $test_userId=$event->getUserId();
		 $reply_token = $event->getReplyToken();
		// pushMessage($test_userId,"Example push text11111",getenv('curlHTTPClient')); // add by vito
	
		//follow event 
        if ($event instanceof \LINE\LINEBot\Event\FollowEvent) { 

			$user_ID=$event->getUserId();
			
			//call get profile
			$response = $bot->getProfile($user_ID);
			$profile = $response->getJSONDecodedBody();
			$displayName = $profile['displayName'];
			//$statusMessage = $profile['statusMessage'];
			//$pictureUrl = $profile['pictureUrl'];
			
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayName."你好呀!!!");  
			$bot->replyMessage($reply_token, $textMessageBuilder);
 
 
        }
		
		//join group event
        if ($event instanceof \LINE\LINEBot\Event\JoinEvent) { 

			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("Hello everybody");  
			$bot->replyMessage($reply_token, $textMessageBuilder);
 
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
				"imagemap" => "bot_imagemap",	
			];			

			if(isset($array[$getText])){
			include('event/'.$array[$getText].'.php');
			}else{ 
			include('event/no_event.php');
			} 
			
			//單筆傳送
			/*
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($getText); //文字
			$stickerMessageBuilder = new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1,17); //貼圖
			
			$response = $bot->replyMessage($reply_token, $stickerMessageBuilder);
			$response =  $bot->replyMessage($reply_token, $textMessageBuilder);
			

			$MultiMessageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
			$MultiMessageBuilder->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($getText)); 
			$MultiMessageBuilder->add(new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1,17)); 
			
			$bot->replyMessage($reply_token, $MultiMessageBuilder);*/
        }

		//location event 		
		if ($event instanceof \LINE\LINEBot\Event\MessageEvent\LocationMessage) {
			
			$getText = $event->getTitle().$event->getAddress().$event->getLatitude().$event->getLongitude();
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($getText);  
			$bot->replyMessage($reply_token, $textMessageBuilder);
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
	// function pushMessage($USERID, $msg,$token)
    // {
    //     $format_text = [
    //         "type" => "text",
    //         "text" => $msg
    //     ];
 
    //     $post_data = [
    //         "to" => $USERID,
    //         "messages" => [$format_text]
    //     ];
 
    //     $header = array(
    //         'Content-Type: application/json',
    //         'Authorization: Bearer ' . $token
    //     );
 
    //     $ch = curl_init('https://api.line.me/v2/bot/message/push');
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
 
    //     $result = curl_exec($ch);
    //     curl_close($ch);
    // }

 ?>