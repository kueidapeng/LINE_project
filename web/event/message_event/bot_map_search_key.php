<?php
 
			/*
			location search key message
			*/
			$redis->updateUserStatus($user_id,'map_key');

			$text = "請輸入您要查詢的關鍵字，例如：星巴克";
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);  
			$bot->replyMessage($reply_token, $textMessageBuilder);

?>