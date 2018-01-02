<?php
			/*
			join event
			*/
			$UtilityHandler= new App\event\UtilityHandler;				//create UtilityHandler object
			$jsonString=$UtilityHandler->getJsonString();				//get json string from description
			$text =$UtilityHandler->tag_translate($jsonString['bot_join_event']);	


			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);  
			$bot->replyMessage($reply_token, $textMessageBuilder);
			
?>			