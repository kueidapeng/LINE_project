<?php
 
 		$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
		$redis->updateUserStatus($user_id,'');
		$Text=str_replace("關鍵字：", '', $getText);
 
		$latlng=$redis->getLocation($user_id);
		$address = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$latlng."&sensor=false&key=AIzaSyCX03bCD5_W0XcW57qxaHsnvw_pDTCLCUQ"),true);

					for($i=0;$i<count($address['results'][0]['address_components']);$i++){
						if($address['results'][0]['address_components'][$i]['types'][0]=='postal_code'){
						$zip_code =substr($address['results'][0]['address_components'][$i]['long_name'],0,3); 
						}
					} 
		
					/*$getText = $event->getTitle().$event->getAddress().$event->getLatitude().$event->getLongitude()."zip_code=".$zip_code;
					 $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($getText);  
					 $bot->replyMessage($reply_token, $textMessageBuilder);*/
					//$contents = json_decode(file_get_contents("https://www.cardhoin.com/apiserver/deviceapi/v1/categories/today_usable/brands?latlng=".$event->getLatitude().",".$event->getLongitude()."&zip_code=".$zip_code."&_offset=0"))->result->cat00456->brands;

					$contents = json_decode(file_get_contents("https://www.cardhoin.com/apiserver/deviceapi/v1/branches/search_t2?latlng=".$latlng."&zip_code=".$zip_code."&keyword=".urlencode($Text)))->result->act006->branches;
					
					if(empty($contents)){

						$text = emoji('10002D')."很抱歉，找不到您要的優惠。";
						$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);  
 
						$MultiMessageBuilder->add($textMessageBuilder);
 

					}else{
					$columns = array();
					foreach($contents as $content){
						
						
						$web_url="https://www.cardhoin.com/brand/".$content->brand->id."/activity/".$content->activities[0]->id;
						$map_url="https://www.google.com.tw/maps/dir/".$content->lat.','.$content->lng."/".$latlng;
						 
						$actions = array(
								new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F449')." 優惠連結",$web_url),
								new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F695')." 地圖導航",$map_url)
							  );
		    
						//$imagemap='https://maps.googleapis.com/maps/api/staticmap?center='.$content->branch->lat.','.$content->branch->lng.'&zoom=18&sensor=false&scale=1&size=600x300&maptype=roadmap&format=png&markers=size:mid%7Ccolor:0xf896b4%7Clabel:%7C'.$content->branch->lat.','.$content->branch->lng;
						$title	=mb_strimwidth($content->activities[0]->title, 0, 58, "..."); // max text 120 
						$column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder(emoji('1F4B3')." ".$content->activities[0]->name,$title, $content->brand->logo_img_url, $actions);
						$columns[] = $column;
				
						
					}
		 
					$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
					$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);
 
					$MultiMessageBuilder->add($msg);
 
					}


					$actions = array(
						new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("是", "map_key=Y"),
						new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("否", "map_key=N")
					  );
					$button = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder("是否要在搜尋其他優惠？", $actions);
					$msg2 = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要用手機的賴才看的到哦", $button);
										

					$MultiMessageBuilder->add($msg2);
					$bot->replyMessage($reply_token,$MultiMessageBuilder);	
 

?>