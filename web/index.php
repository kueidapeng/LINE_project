<?php 
require_once 'event/RedisHandler.php';
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

//error_log("Signature: ".$signature);

    $events = $bot->parseEventRequest($body, $signature);
	
//error_log("events: ".$events);
    foreach ($events as $event){
	
		$reply_token = $event->getReplyToken();
		$user_ID=$event->getUserId();
		$redis= new RedisHandler;
		$redis->checkUserId($user_ID);

		//follow event 
        if ($event instanceof \LINE\LINEBot\Event\FollowEvent) { 

			include('event/follow_event/bot_follow_event.php');

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
				"video" => "bot_video",
				
				"座標優惠收尋" => "bot_map_search",				
			];			

			if(isset($array[$getText])){
			include('event/message_event/'.$array[$getText].'.php');
			}else{ 
			include('event/message_event/no_event.php');
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
 
			$address = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?latlng=".$event->getLatitude().",".$event->getLongitude()."&sensor=false"),true);


			for($i=0;$i<count($address['results'][0]['address_components']);$i++){
				if($address['results'][0]['address_components'][$i]['types'][0]=='postal_code'){
				$zip_code =substr($address['results'][0]['address_components'][$i]['long_name'],0,3); 
				}
			} 

			/*$getText = $event->getTitle().$event->getAddress().$event->getLatitude().$event->getLongitude()."zip_code=".$zip_code;
			 $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($getText);  
			 $bot->replyMessage($reply_token, $textMessageBuilder);*/

			$contents = json_decode(file_get_contents("https://www.cardhoin.com/apiserver/deviceapi/v1/categories/today_usable/brands?latlng=".$event->getLatitude().",".$event->getLongitude()."&zip_code=".$zip_code."&_offset=0"))->result->cat00456->brands;
			$columns = array();
			foreach($contents as $content){
				
				
				$web_url="https://www.cardhoin.com/brand/".$content->id."/activity/".$content->activity->id;
				$map_url="https://www.google.com.tw/maps/dir/".$content->branch->lat.','.$content->branch->lng."/".$event->getLatitude().",".$event->getLongitude();
				 
				$actions = array(
						new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F449')." 優惠連結",$web_url),
						new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F695')." 地圖導航",$map_url)
					  );

					  //$imagemap='https://maps.googleapis.com/maps/api/staticmap?center='.$content->branch->lat.','.$content->branch->lng.'&zoom=18&sensor=false&scale=1&size=600x300&maptype=roadmap&format=png&markers=size:mid%7Ccolor:0xf896b4%7Clabel:%7C'.$content->branch->lat.','.$content->branch->lng;
				$column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder(emoji('1F4B3')." ".$content->activity->name,$content->activity->title, $content->logo_img_url, $actions);
				$columns[] = $column;
		
				
			}
			
	
		
			$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
			$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);
			$bot->replyMessage($reply_token,$msg);
			
			

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