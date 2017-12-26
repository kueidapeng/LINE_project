<?php
 
 	$thumbnailImageUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/location_search.png?_ignore=';
	$actions = array(
 
		new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder(emoji('1F50D')." 類別搜尋", "map_cat=Y"),
		new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder(emoji('1F50D')." 關鍵字搜尋", "map_key=Y"),	
	    new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F4CD')." 分享位置", "line://nv/location")
		);
				
 
	$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder("座標優惠搜尋","請先定位座標或點選下方分享位置，再選擇關鍵字或類別搜尋。", $thumbnailImageUrl,$actions);
	$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);
	$bot->replyMessage($reply_token,$msg);


?>