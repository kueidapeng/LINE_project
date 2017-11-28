<?php 

require_once __DIR__ . '/vendor/autoload.php';
 
 $bot = new \LINE\LINEBot(
  new \LINE\LINEBot\HTTPClient\CurlHTTPClient('nWO1xSc7dTcojx0ztJQxqkQwf/xSHLihc5RQI1tyjtS8fTDVUiUD8eSjvmGDWqxWZvQOnCHbLVLlEYB4qf+UUiuCUN2XNOwE7rNl6PpawiZCSFUSSoDS8qv6ijh25Apl5EY+xRk7RudlgNoPFgtJwgdB04t89/1O/w1cDnyilFU='),
  ['channelSecret' => '23a6bd00bb961c5e2764ca2d9ca37860']
);
 
$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
 
$body = file_get_contents("php://input");
    $events = $bot->parseEventRequest($body, $signature);
    foreach ($events as $event) {
		
        if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) { //return為文字訊息
            
			$reply_token = $event->getReplyToken();
			$getText = $event->getText();
			
			//單筆傳送
			/*
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($getText); //文字
			$stickerMessageBuilder = new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1,17); //貼圖
			
			$response = $bot->replyMessage($reply_token, $stickerMessageBuilder);
			$response =  $bot->replyMessage($reply_token, $textMessageBuilder);
			*/
			
			$MultiMessageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
			 
			$MultiMessageBuilder->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($getText)); 
			$MultiMessageBuilder->add(new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1,17)); 
			
			$bot->replyMessage($reply_token, $MultiMessageBuilder);
        }
    }
 

/*$client = new LINEBotTiny($channelAccessToken, $channelSecret);
 
 
 include_once "LINEBotTiny.php";
 
 
//$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello'); 
 
foreach ($client->parseEvents() as $event) {
    $client->replyMessage(array(
        'replyToken' => $event['replyToken'],
        'messages' => array(
            array(
                'type' => 'text',
                'text' => "sssss"
            )
        )
    ));
};*/

 ?>