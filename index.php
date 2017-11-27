<?php 

require_once __DIR__ . '/vendor/autoload.php';
 
 $bot = new \LINE\LINEBot(
  new \LINE\LINEBot\HTTPClient\CurlHTTPClient(''),
  ['channelSecret' => '']
);
 
$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];




$body = file_get_contents("php://input");
    $events = $bot->parseEventRequest($body, $signature);
    foreach ($events as $event) {
        if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
            $reply_token = $event->getReplyToken();

    $bot->replyText($reply_token, "11111");
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