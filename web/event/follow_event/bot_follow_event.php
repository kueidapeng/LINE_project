<?php
			/*
			follow event
			*/
			$UtilityHandler= new App\event\UtilityHandler;				//create UtilityHandler object
			$jsonString=$UtilityHandler->getJsonString();				//get json string from description

			$user_ID=$event->getUserId();
			$redis->addUserId($user_ID); //add user_id to redis row
			
			//call get profile
			$response = $bot->getProfile($user_ID);
			$profile = $response->getJSONDecodedBody();
			$displayName = $profile['displayName'];
 
			$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

			$pattern_angle = "/\{{(.*?)\}}/"; // remain{{}}
			$pattern_square = "/\{{(.*)\s\w+='(.*)'\}}/"; // deal with{{...}}
		                                                  // Tag content_og_tag
																			
			// Tag content
			preg_match_all($pattern_angle, $jsonString['bot_follow_event'], $matches_angle);
			foreach ($matches_angle[0] as $angle) {
				preg_match_all($pattern_square, $angle, $matches);
				if (isset($matches[0][0])) {
					$be_replaced[] = $matches[0][0]; // save string be replace
					$replacement[] = $UtilityHandler->{$matches[1][0]}($matches[2][0]); // save replace string
				}
			}
			if (isset($be_replaced) && isset($replacement))
			$Text = str_replace($be_replaced, $replacement, trim($jsonString['bot_follow_event']));
		
			
			$columns = array();
			$baseUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/menu.png?_ignore=';
			//error_log('1.$baseUrl: '.$baseUrl);
			//error_log('2.$profile: '.$profile);

			$altText="卡好用LINE服務";
			
			$baseSizeBuilder = new LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder(1040,1040);
			$areaBuilderLT = new LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(17,215,500,400); 	//LT block
			$areaBuilderRT = new LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(523,210,500,400);	//RT block
			$areaBuilderLD = new LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(17,623,500,400);	//LD block
			$areaBuilderRD = new LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(523,623,500,400);	//RD block

			$linkUri1="https://www.cardhoin.com/category/today?offset=10";
			$linkUri2="https://www.cardhoin.com/category/hot?offset=10";
			$linkUri3="https://www.cardhoin.com/category/new?offset=10";
			$linkUri4="座標優惠搜尋";
			
			$columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder($linkUri1,$areaBuilderLT);
			$columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder($linkUri2,$areaBuilderRT);
			$columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder($linkUri3,$areaBuilderLD);
			$columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($linkUri4,$areaBuilderRD);

			$MultiMessageBuilder->add(new LINE\LINEBot\MessageBuilder\TextMessageBuilder($Text));
			$MultiMessageBuilder->add(new LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder($baseUrl,$altText,$baseSizeBuilder,$columns));

			$bot->replyMessage($reply_token, $MultiMessageBuilder);
			 
?>			