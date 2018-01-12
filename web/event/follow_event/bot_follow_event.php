<?php
			/*
			follow event
			*/
			$thumbnailImageUrl=null;
			$UtilityHandler= new App\event\UtilityHandler;				//create UtilityHandler object
			$jsonString=$UtilityHandler->getJsonString();				//get json string from description

			$user_ID=$event->getUserId();
			$redis->addUserId($user_ID); //add user_id to redis row
			$redis->updateUserStatus($user_id,'');
			
			//call get profile
			$response = $bot->getProfile($user_ID);
			$profile = $response->getJSONDecodedBody();
			$displayName = $profile['displayName'];
 
			$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

			$Text =$displayName.$UtilityHandler->tag_translate($jsonString['bot_follow_event']);	
					
			$redis->updateUserStatus($user_id,'no_location');
			$actions = array(   new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F4CD')." 定位座標", "line://nv/location")  );
							   		
			$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder(emoji('1F50D')." 優惠搜尋","請先點下方選定位座標。", $thumbnailImageUrl,$actions);
			$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder(emoji('1F50D')."這訊息要在手機上才能看唷", $carousel);

			$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
			$MultiMessageBuilder->add(new LINE\LINEBot\MessageBuilder\TextMessageBuilder($Text));
			$MultiMessageBuilder->add($msg);
			$bot->replyMessage($reply_token, $MultiMessageBuilder);
?>			