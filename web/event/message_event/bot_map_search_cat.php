<?php
 
		/*
			location search cat message
		*/ 
 
 		$redis->updateUserStatus($user_id,'map_cat');

				$contents = json_decode(file_get_contents("https://www.cardhoin.com/apiserver/deviceapi/v1/categories?page_type=menu"))->result->cat001->categories;
				$columns = array();
				foreach($contents as $content){

					$img_src="https://". $_SERVER['HTTP_HOST']."/line_bot/image/".$content->category_code.".png";

					$actions = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder(emoji('2B50').$content->name,'map_cat_name='.$content->name);

							$column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder($img_src, $actions);
							$columns[] = $column;
			
					
				}
				
			$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder($columns);
			$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);
			$bot->replyMessage($reply_token,$msg);
 

?>