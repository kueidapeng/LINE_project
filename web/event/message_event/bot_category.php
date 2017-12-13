<?php
 
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($getText); //文字
 
			$response =  $bot->replyMessage($reply_token, $textMessageBuilder);
 

?>