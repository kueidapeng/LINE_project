<?php
			/*
			follow event
			*/
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
			
			$imagemap= new App\event\message_event\ImagemapHandler;				//create imagemap object
			$ImageMessageBuilder=$imagemap->createImagemap();

			$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
	
			$MultiMessageBuilder->add(new LINE\LINEBot\MessageBuilder\TextMessageBuilder($Text));
			$MultiMessageBuilder->add($ImageMessageBuilder);
			$bot->replyMessage($reply_token, $MultiMessageBuilder);
			 
?>			