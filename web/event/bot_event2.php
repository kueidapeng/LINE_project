 
<?php

 
 
			 $columns = array();
			$img_url = "https://4.share.photo.xuite.net/min0427/140d536/6411593/262027757_x.jpg";
	 

			  $actions = array(
				//一般訊息型 action
				new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder("按鈕1","文字1"),
				//網址型 action
				new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("觀看食記","http://www.google.com")
			  );
			  $column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("標題1", "說明1", $img_url , $actions);

	
			$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
			$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要用手機的賴才看的到哦", $carousel);
			$bot->replyMessage($reply_token,$msg);

?>
 