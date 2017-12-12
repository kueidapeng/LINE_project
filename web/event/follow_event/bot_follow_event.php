<?php
			/*
			follow event
			*/
			
			$user_ID=$event->getUserId();
			
			//call get profile
			$response = $bot->getProfile($user_ID);
			$profile = $response->getJSONDecodedBody();
			$displayName = $profile['displayName'];
			$statusMessage = $profile['statusMessage'];
			$pictureUrl = $profile['pictureUrl'];
 
			$MultiMessageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

			$Text = $displayName."你好".emoji('10002D')."\r\n感謝您加入卡好用帳號，卡好用幫你整理銀行和商家合作的信用卡優惠，讓你將消費省下的小錢，漸漸累積成一筆小財富！。"
					.emoji('100080')."\r\n\r\n".emoji('10003D')."卡好用APP\r\n".emoji('100084')."iOS - bit.ly/FBabout_iOS\r\n".emoji('100084')."Android - bit.ly/FBabout_Android\r\n";
 
		    $columns = array();
<<<<<<< HEAD
			$baseUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/menu.png?_ignore=';
=======
			$baseUrl='https://'. $_SERVER['HTTP_HOST'].'/image/menu.png?_ignore=';
error_log('1.$baseUrl: '.$baseUrl);
error_log('2.$profile: '.$profile);

>>>>>>> 6167f3a19ec3fe1e66af5fc3eca154ef52a79038
			$altText="卡好用menu";
			
			$baseSizeBuilder = new \LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder(1040,1040);
			$areaBuilderLT = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(17,215,500,400); 	//LT block
			$areaBuilderRT = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(523,210,500,400);	//RT block
			$areaBuilderLD = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(17,623,500,400);	//LD block
			$areaBuilderRD = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(523,623,500,400);	//RD block

			$linkUri1="https://www.cardhoin.com/category/today?offset=10";
			$linkUri2="https://www.cardhoin.com/category/hot?offset=10";
			$linkUri3="https://www.cardhoin.com/category/new?offset=10";
			$linkUri4="座標優惠收尋";
			
			$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder($linkUri1,$areaBuilderLT);
			$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder($linkUri2,$areaBuilderRT);
			$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder($linkUri3,$areaBuilderLD);
			$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($linkUri4,$areaBuilderRD);

			$originalContentUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/card.mp4';
			$previewImageUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/video_img.png';
 
			$MultiMessageBuilder->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($Text));
			$MultiMessageBuilder->add(new \LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder($baseUrl,$altText,$baseSizeBuilder,$columns));
			$MultiMessageBuilder->add(new \LINE\LINEBot\MessageBuilder\VideoMessageBuilder($originalContentUrl,$previewImageUrl));
			 
			$bot->replyMessage($reply_token, $MultiMessageBuilder);
			
?>			