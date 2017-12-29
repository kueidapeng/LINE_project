<?php
 
 	$thumbnailImageUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/location_search.png?_ignore=';


	 if($redis->checkUserId($user_id)==0){  //no user_id

		$redis->updateUserStatus($user_id,'no_user_id');
		
				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請加入卡好用BOT才能享有此功能唷"); //文字
				$response =  $bot->replyMessage($reply_token, $textMessageBuilder);
		
	}else if($redis->checkLocation($user_id)==0){ //no location
		
		$redis->updateUserStatus($user_id,'no_location');
		
				$originalContentUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/location_desc.png';
				$previewImageUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/location_desc.png';


				$actions = array(
 
						   new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F4CD')." 定位座標", "line://nv/location")
						   );
								   
					
				$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder("優惠搜尋","請先點下方選定位座標。", $thumbnailImageUrl,$actions);
				$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);

				$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
		
				$ImageMessageBuilder = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalContentUrl,$previewImageUrl); //文字
				//$Text = new LINE\LINEBot\MessageBuilder\TextMessageBuilder("定位完成以後請再次點選定定位收尋(若想更改座標重新定位)。".emoji('100033'));
				$MultiMessageBuilder->add($msg);
				//$MultiMessageBuilder->add($ImageMessageBuilder);
				//$MultiMessageBuilder->add($Text);
				$bot->replyMessage($reply_token, $MultiMessageBuilder);
		
	}else{



		$latlng=$redis->getLocation($user_id);
		$address = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$latlng."&sensor=false&language=zh-TW"),true);


		for($i=0;$i<count($address['results'][0]['address_components']);$i++){
			if($address['results'][0]['address_components'][$i]['types'][0]=='postal_code'){
			$zip_code =substr($address['results'][0]['address_components'][$i]['long_name'],0,3); 
			}
		} 

		https://www.cardhoin.com/apiserver/deviceapi/v1/geoes/live?zip_code=106
		$contents = json_decode(file_get_contents("https://www.cardhoin.com/apiserver/deviceapi/v1/geoes/live?zip_code=".$zip_code))->result->geo003->geo;
		
		$area_level_1=$contents->parent->value;
		$area_level_2=$contents->value;

	 $actions = array(
 
		new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder(emoji('1F50D')." 類別搜尋", "map_cat=Y"),
		new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder(emoji('1F50D')." 關鍵字搜尋", "map_key=Y"),	
	    new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F4CD')." 更新位置", "line://nv/location")
		);
				
 
	$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder("優惠搜尋","目前定位點： ".$area_level_1." ➤ ".$area_level_2."\n若要更改地點請點選更新位置。", $thumbnailImageUrl,$actions);
	$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);
	$bot->replyMessage($reply_token,$msg);

	}
?>