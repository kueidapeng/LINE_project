<?php
 
			/*
			location search key message
			*/

 			
			$redis->updateUserStatus($user_id,'map_key');

			$text = emoji('100077')."請輸入文字或錄製語音查詢您要的關鍵字。例如：星巴克";
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);  
			$bot->replyMessage($reply_token, $textMessageBuilder);
 

?>