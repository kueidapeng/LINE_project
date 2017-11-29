 
<?php
			$originalContentUrl="https://4.share.photo.xuite.net/min0427/140d536/6411593/262027757_x.jpg";
			$previewImageUrl="https://4.share.photo.xuite.net/min0427/140d536/6411593/262027757_x.jpg";
 
			$ImageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalContentUrl,$previewImageUrl); //文字
 
			$response =  $bot->replyMessage($reply_token, $ImageMessageBuilder);
 

?>
 