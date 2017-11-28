<?php 

include('../config/config.php');
require_once '../vendor/autoload.php';

 $bot = new \LINE\LINEBot(
  new \LINE\LINEBot\HTTPClient\CurlHTTPClient($config['bot_setting']['curlHTTPClient']),
  ['channelSecret' => $config['bot_setting']['channelSecret']]
);
 
$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
 
$body = file_get_contents("php://input");
    $events = $bot->parseEventRequest($body, $signature);
    foreach ($events as $event) {
        if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
            
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