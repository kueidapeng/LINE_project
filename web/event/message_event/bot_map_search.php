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
								   
					
				$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder("座標優惠搜尋","請先點下方選定位座標。", $thumbnailImageUrl,$actions);
				$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);

				$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
		
				$ImageMessageBuilder = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalContentUrl,$previewImageUrl); //文字
				//$Text = new LINE\LINEBot\MessageBuilder\TextMessageBuilder("定位完成以後請再次點選定定位收尋(若想更改座標重新定位)。".emoji('100033'));
				$MultiMessageBuilder->add($msg);
				//$MultiMessageBuilder->add($ImageMessageBuilder);
				//$MultiMessageBuilder->add($Text);
				$bot->replyMessage($reply_token, $MultiMessageBuilder);
		
	}else{


	 $actions = array(
 
		new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder(emoji('1F50D')." 類別搜尋", "map_cat=Y"),
		new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder(emoji('1F50D')." 關鍵字搜尋", "map_key=Y"),	
	    new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F4CD')." 更新位置", "line://nv/location")
		);
				
 
	$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder("座標優惠搜尋","選擇關鍵字或類別搜尋，若要更改地點請點選更新位置。", $thumbnailImageUrl,$actions);
	$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);
	$bot->replyMessage($reply_token,$msg);

	}
?>