 
<?php
			$textMessage = '\x{1F622} 很抱歉，我不知道你在說什麼。\x{1F623}';
 			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textMessage);  
			$response =  $bot->replyMessage($reply_token, $textMessageBuilder);

?>
 