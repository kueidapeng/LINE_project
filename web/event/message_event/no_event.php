﻿ 
<?php
$redis->updateUserStatus($user_id,'');
		//	$textMessage = emoji(100086)."抱歉，我不清楚您說什麼，沒辦法回答您可利用下方 '關鍵字' 或\n '類別圖示' 點選需要的服務。".emoji(100094);
			$textMessage = emoji(100086)."抱歉，線上人員忙碌中，沒辦法回答您可利用下方 '關鍵字' 或\n '類別圖示' 點選需要的服務。".emoji(100094);	 
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textMessage);  
	
			$imagemap= new App\event\message_event\ImagemapHandler;				//create imagemap object
			$ImageMessageBuilder=$imagemap->createImagemap();

			$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
	
			$MultiMessageBuilder->add($textMessageBuilder);
			$MultiMessageBuilder->add($ImageMessageBuilder);

			$response =  $bot->replyMessage($reply_token, $MultiMessageBuilder);
?>
 