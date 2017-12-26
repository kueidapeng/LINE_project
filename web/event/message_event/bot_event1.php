 
<?php
 
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("line://nv/location"); //文字
 
			$response = $bot->pushMessage($user_id, $textMessageBuilder);
			
 
			$bot->replyMessage($reply_token, $textMessageBuilder);
?>
 