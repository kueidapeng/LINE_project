 
<?php

			$textMessage =emoji('1F4F1')."卡好用APP\r\n".emoji('2B50')." iOS- bit.ly/FBabout_iOS\r\n".emoji('2B50')." Android- bit.ly/FBabout_Android";
 			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textMessage);  
			$response =  $bot->replyMessage($reply_token, $textMessageBuilder);
?>
 