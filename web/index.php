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
		
		$columns = array();
		$img_url = "圖片網址，必需為 https (圖片非必填欄位)";
		for($i=0;$i<5;$i++) //最多5筆
		{
		  $actions = array(
			//一般訊息型 action
			new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder("按鈕1","文字1"),
			//網址型 action
			new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("觀看食記","http://www.google.com")
		  );
		  $column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("標題".$i, "說明".$i, $img_url , $actions);
		  $columns[] = $column;
		}
		$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
		$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要用手機的賴才看的到哦", $carousel);
		$bot->replyMessage($replyToken,$msg);
		
    }
 

 ?>