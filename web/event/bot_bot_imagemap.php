 
<?php

			$columns = array();
			$baseUrl="https://4.share.photo.xuite.net/min0427/140d536/6411593/262027757_x.jpg";
			$altText="方塊圖片";
			
			$baseSizeBuilder = new \LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder(1040,1040);
			$areaBuilder = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder(0,0,520,1040);
			
			$linkUri='https://www.google.com.tw/';
			
			$actions = array(
			$linkUri,
			new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder($areaBuilder)
			);
 
			$ImageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder($originalContentUrl,$previewImageUrl,$baseSizeBuilder,$actions);  
 
			$response =  $bot->replyMessage($reply_token, $ImageMessageBuilder);
 

?>
 