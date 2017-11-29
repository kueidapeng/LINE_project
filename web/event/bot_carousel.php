<?php
        $columns = array();
		$img_url = "https://github.com/chliwei199/images/raw/master/str1.png";
		for($i=0;$i<5;$i++) //最多5筆
		{
		  $actions = array(
			//一般訊息型 action
			new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder("按鈕1","文字1"),
			//網址型 action
			new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("觀看食記","http://www.google.com")
		  );
		  $column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("標題".$i, "說明".$i, $img_url , $actions);
		  $columns[] = $column;
		}
		$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
		$msg = new \LINE\LINEBot\MessageBuilder\TemplateBuilder("這訊息要用手機的賴才看的到哦", $carousel);
		$bot->replyMessage($replyToken,$msg);