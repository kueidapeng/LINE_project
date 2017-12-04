<?php
		$news = json_decode(file_get_contents("https://newsapi.org/v2/top-headlines?sources=bbc-news&apiKey=".getenv('apiKey_bbc')))->articles;
        $columns = array();
		foreach($news as $new){
			$actions = array(
					//網址型 action
					new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("連結",$new->url)
				  );
				  $column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder($new->author, $new->title,$new->urlToImage, $actions);
				  $columns[] = $column;
		}
	
		$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
		$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要用手機的賴才看的到哦", $carousel);
        $bot->replyMessage($reply_token,$msg);
