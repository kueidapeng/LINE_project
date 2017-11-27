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