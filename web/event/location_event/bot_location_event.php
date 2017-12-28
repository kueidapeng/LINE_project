<?php
			/*
			location event
			*/

			$thumbnailImageUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/location_search.png?_ignore=';			

			if($redis->checkLocation($user_id)==0){ // location add
				$result_Location=$redis->addUserLocation($user_id,$event->getLatitude(),$event->getLongitude());
				
				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("所在座標已新增".emoji('10008F')); //文字
				//$response =  $bot->replyMessage($reply_token, $textMessageBuilder);
			}else{ // location update	
				$result_Location=$redis->updateUserLocation($user_id,$event->getLatitude(),$event->getLongitude());

				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("所在座標已更新".emoji('10008F')); //文字
				//$response =  $bot->replyMessage($reply_token, $textMessageBuilder);
				
			}

			$actions = array(
			new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder(emoji('1F50D')." 類別搜尋", "map_cat=Y"),
			new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder(emoji('1F50D')." 關鍵字搜尋", "map_key=Y"),	
			new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F4CD')." 更新位置", "line://nv/location")
			);
					
	 
			$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

			$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder("座標優惠搜尋","選擇關鍵字或類別搜尋，若要更改地點請點選更新位置。", $thumbnailImageUrl,$actions);
			$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);

			$MultiMessageBuilder->add($textMessageBuilder);
			$MultiMessageBuilder->add($msg);
			
			$bot->replyMessage($reply_token,$MultiMessageBuilder);
			
?>			