 
<?php
			$originalContentUrl='https://'. $_SERVER['HTTP_HOST'].'/image/location_desc.png';
			$previewImageUrl='https://'. $_SERVER['HTTP_HOST'].'/image/location_desc.png';
 
			$ImageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalContentUrl,$previewImageUrl); //文字
 
			$response =  $bot->replyMessage($reply_token, $ImageMessageBuilder);
 

?>
 