<?php
 
				$contents = json_decode(file_get_contents("https://www.cardhoin.com/apiserver/deviceapi/v1/categories?page_type=menu"))->result->cat001->categories;
				$columns = array();
				foreach($contents as $content){

					$actions = array(
							new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder(emoji('1F5FE')." 定位收尋",$content->name)
							);
							
							$column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder($content->description,$content->name, 'https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/'.$content->category_code.'.png', $actions);
							$columns[] = $column;
			
					
				}
				
			$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
			$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);
			$bot->replyMessage($reply_token,$msg);

?>