<?php
			/*
			join event
			*/
			$text = emoji('10002D')."大家我是卡好用BOT，歡迎加入好友，提供更多服務給您，卡好用關心您。".emoji('100005');
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);  
			$bot->replyMessage($reply_token, $textMessageBuilder);
			
?>			