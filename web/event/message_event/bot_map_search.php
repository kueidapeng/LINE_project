<?php
 
 	$thumbnailImageUrl=null;
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
								   
					
				$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder(emoji('1F50D')." 優惠搜尋","請先點下方選定位座標。", $thumbnailImageUrl,$actions);
				$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder(emoji('1F50D')."這訊息要在手機上才能看唷", $carousel);

				$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
		
				$ImageMessageBuilder = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalContentUrl,$previewImageUrl); //文字
			
				$MultiMessageBuilder->add($msg);
				$bot->replyMessage($reply_token, $MultiMessageBuilder);
		
	}else{

		$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

		$latlng=$redis->getLocation($user_id);
		$zip_code =$redis->getzipcode($user_id);

		$contents = json_decode(file_get_contents("http://dev-cardhoin.xyzcamp.info/apiserver/deviceapi/v1/geoes/live?zip_code=".$zip_code))->result->geo003->geo;
		
		$area_level_1=$contents->parent->value;
		$area_level_2=$contents->value;

	   $actions = array(
	    new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F4CD')." 更新位置", "line://nv/location")
		);

		$imagemap= new App\event\message_event\ImagemapHandler;				//create imagemap object
		$ImageMessageBuilder=$imagemap->createImagemap();
 
	$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder(emoji('1F50D')." 優惠搜尋","目前定位點： ".$area_level_1." ➤ ".$area_level_2."\n若要更改地點請點選更新位置。", $thumbnailImageUrl,$actions);
	$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder(emoji('1F50D')."這訊息要在手機上才能看唷", $carousel);
	
	$MultiMessageBuilder->add($msg);	
	$MultiMessageBuilder->add($ImageMessageBuilder);

	$bot->replyMessage($reply_token,$MultiMessageBuilder);	
 	}
?>