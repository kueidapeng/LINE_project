 
<?php
			$textMessage = emoji(100086).'抱歉，我不清楚您說什麼，沒辦法回答您'.emoji(100094).'可利用下方的圖示點選需要的服務。';
 			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textMessage);  
	
			$imagemap= new App\event\message_event\ImagemapHandler;				//create imagemap object
			$ImageMessageBuilder=$imagemap->createImagemap();

			$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
	
			$MultiMessageBuilder->add($textMessageBuilder);
			$MultiMessageBuilder->add($ImageMessageBuilder);

			$response =  $bot->replyMessage($reply_token, $MultiMessageBuilder);
?>
 