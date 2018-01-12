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
		
			$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
			$MultiMessageBuilder->add(new LINE\LINEBot\MessageBuilder\TextMessageBuilder($Text));
			$MultiMessageBuilder->add($UtilityHandler->askAddLocation());   //ask user add location
			$bot->replyMessage($reply_token, $MultiMessageBuilder);
?>			