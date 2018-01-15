<?php
			/*
			location event
			*/
			$thumbnailImageUrl=null;
		
			if($redis->checkLocation($user_id)==0){ // location add
				$result_Location=$redis->addUserLocation($user_id,$event->getLatitude(),$event->getLongitude());
				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("所在座標已新增".emoji('10008F')); //文字
			}else{ // location update	
				$result_Location=$redis->updateUserLocation($user_id,$event->getLatitude(),$event->getLongitude());

				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("所在座標已更新".emoji('10008F')); //文字				
			}

			
			$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
			
					$latlng=$redis->getLocation($user_id);
					$address = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$latlng."&region=taiwan&language=zh-TW"),true);
			
			
					for($i=0;$i<count($address['results'][0]['address_components']);$i++){
						if($address['results'][0]['address_components'][$i]['types'][0]=='postal_code'){
						$zip_code =substr($address['results'][0]['address_components'][$i]['long_name'],0,3);
						$redis->updateZipCode($user_id,$zip_code);
						}
					} 
					sleep(1);
					$contents = json_decode(file_get_contents("https://www.cardhoin.com/apiserver/deviceapi/v1/geoes/live?zip_code=".$zip_code))->result->geo003->geo;
					
					$area_level_1=$contents->parent->value;
					$area_level_2=$contents->value;
			
				   $actions = array(
					new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F4CD')." 更新位置", "line://nv/location")
					);
			
					$imagemap= new App\event\message_event\ImagemapHandler;				//create imagemap object
					$ImageMessageBuilder=$imagemap->createImagemap();							   	
							
			 
				$carousel = new LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder(emoji('1F50D')." 優惠搜尋","目前定位點： ".$area_level_1." ➤ ".$area_level_2."\n若要更改地點請點選更新位置。", $thumbnailImageUrl,$actions);
				$msg = new LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);
	 
			$MultiMessageBuilder->add($textMessageBuilder);
			$MultiMessageBuilder->add($msg);
			$MultiMessageBuilder->add($ImageMessageBuilder);
			$bot->replyMessage($reply_token,$MultiMessageBuilder);
?>			