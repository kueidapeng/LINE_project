<?php 

require_once '../vendor/autoload.php';

 $bot = new \LINE\LINEBot(
  new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('curlHTTPClient')),
  ['channelSecret' => getenv('channelSecret')]
);
 
$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
 
$body = file_get_contents("php://input");
    $events = $bot->parseEventRequest($body, $signature);
	
    foreach ($events as $event){
	
		$reply_token = $event->getReplyToken();
		
		//join group event
        if ($event instanceof \LINE\LINEBot\Event\JoinEvent) { 

			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("Hello everybody");  
			$bot->replyMessage($reply_token, $textMessageBuilder);
 
        }
 
		//text event 
        if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
			$getText = $event->getText();
 
			$array = [
				"安安" => "bot_event1.php",
				"掰掰" => "bot_event2.php",
				"顆顆" => "bot_event3.php",
				"轉" => "bot_carousel.php",				
			];			

			if(isset($array[$getText])){
			include('event/'.$array[$getText]);
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
	
    }
 

 ?>