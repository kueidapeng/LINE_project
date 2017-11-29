 
<?php
			$textMessage = '\uDBC0\uDC84';
 			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textMessage);  
			$response =  $bot->replyMessage($reply_token, $textMessageBuilder);

?>
 