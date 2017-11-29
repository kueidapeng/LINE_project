 
<?php
 
 			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('&#10007B;&#10007B;'); //文字
			$response =  $bot->replyMessage($reply_token, $textMessageBuilder);

?>
 