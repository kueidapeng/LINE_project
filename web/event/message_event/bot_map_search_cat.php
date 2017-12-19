<?php
 
		/*
			location search cat message
		*/ 
		if($redis->checkUserId($user_id)==0){  //no user_id
			
					$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請加入卡好用BOT才能享有此功能唷"); //文字
					$response =  $bot->replyMessage($reply_token, $textMessageBuilder);
			
				}else if($redis->checkLocation($user_id)==0){ //no location
			
					$originalContentUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/location_desc.png';
					$previewImageUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/location_desc.png';
			
					$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
			
					$ImageMessageBuilder = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalContentUrl,$previewImageUrl); //文字
					$Text = new LINE\LINEBot\MessageBuilder\TextMessageBuilder("定位完成以後請再次點選定定位收尋(若想更改座標重新定位)。".emoji('100033'));
					$MultiMessageBuilder->add($ImageMessageBuilder);
					$MultiMessageBuilder->add($Text);
					$bot->replyMessage($reply_token, $MultiMessageBuilder);
			
				}else{
 		$redis->updateUserStatus($user_id,'map_cat');

				$contents = json_decode(file_get_contents("https://www.cardhoin.com/apiserver/deviceapi/v1/categories?page_type=menu"))->result->cat001->categories;
				$columns = array();
				foreach($contents as $content){

					$actions = new \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder(emoji('2B50').$content->name,'類別：'.$content->name);
							
							$column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder('https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/'.$content->category_code.'.png', $actions);
							$columns[] = $column;
			
					
				}
				
			$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder($columns);
			$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);
			$bot->replyMessage($reply_token,$msg);
				}

?>