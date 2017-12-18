<?php
 
 	$thumbnailImageUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/location_search.png?_ignore=';
	$actions = array(
		new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder(emoji('1F5FE')." 類別搜尋",'類別搜尋'),
		new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder(emoji('1F5FE')." 關鍵字搜尋",'關鍵字搜尋')
		);
				
 
	$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder("座標優惠搜尋","你可以使用定位座標點，用關鍵字或是類別找出您要的優惠訊息。", $thumbnailImageUrl,$actions);
	$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);
	$bot->replyMessage($reply_token,$msg);


?>