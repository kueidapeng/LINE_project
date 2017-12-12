 
<?php
			$textMessage = '􀂆 抱歉，我不知道你在說什麼，我沒辦法回答您。􀂔 ';
 			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textMessage);  
			$response =  $bot->replyMessage($reply_token, $textMessageBuilder);

?>
 