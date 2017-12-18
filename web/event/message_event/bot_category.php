<?php
 
	if($redis->checkUserId($user_id)==0){  //no user_id

		$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請加入卡好用BOT才能享有此功能唷"); //文字
		$response =  $bot->replyMessage($reply_token, $textMessageBuilder);

	}else if($redis->checkLocation($user_id)==0){ //no location

		$originalContentUrl='https://'. $_SERVER['HTTP_HOST'].'/image/location_desc.png';
		$previewImageUrl='https://'. $_SERVER['HTTP_HOST'].'/image/location_desc.png';

		$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

		$ImageMessageBuilder = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalContentUrl,$previewImageUrl); //文字
		$Text = new LINE\LINEBot\MessageBuilder\TextMessageBuilder("定位完成以後請再次點選定定位收尋(若想更改座標重新定位)。".emoji('100033'));
		$MultiMessageBuilder->add($ImageMessageBuilder);
		$MultiMessageBuilder->add($Text);
		$bot->replyMessage($reply_token, $MultiMessageBuilder);

	}else{
		
		$redis->updateUserStatus($user_id,'');
		$Text=str_replace("類別：", '', $getText);
		$category = json_decode(file_get_contents("https://www.cardhoin.com/apiserver/deviceapi/v1/categories?page_type=menu"),true);
		
		$category_id='';
		for($i=0;$i<count($category['result']['cat001']['categories']);$i++){
			if($category['result']['cat001']['categories'][$i]['name']==$Text){
				$category_id=$category['result']['cat001']['categories'][$i]['id'];
			}
		} 
 

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

					$contents = json_decode(file_get_contents("https://www.cardhoin.com/apiserver/deviceapi/v1/categories_a/".$category_id."/brands/distinct?latlng=".$latlng."&zip_code=".$zip_code."&_offset=0"))->result->cat003->brands;
					$columns = array();
					foreach($contents as $content){
						
						
						$web_url="https://www.cardhoin.com/brand/".$content->id."/activity/".$content->activity->id;
						$map_url="https://www.google.com.tw/maps/dir/".$content->branch->lat.','.$content->branch->lng."/".$latlng;
						 
						$actions = array(
								new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F449')." 優惠連結",$web_url),
								new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F695')." 地圖導航",$map_url)
							  );
		    
						//$imagemap='https://maps.googleapis.com/maps/api/staticmap?center='.$content->branch->lat.','.$content->branch->lng.'&zoom=18&sensor=false&scale=1&size=600x300&maptype=roadmap&format=png&markers=size:mid%7Ccolor:0xf896b4%7Clabel:%7C'.$content->branch->lat.','.$content->branch->lng;
						$title	=mb_strimwidth($content->activity->title, 0, 58, "..."); // max text 120 
						$column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder(emoji('1F4B3')." ".$content->activity->name,$title, $content->logo_img_url, $actions);
						$columns[] = $column;
				
						
					}
					
			
				
					$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($columns);
					$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);
					$bot->replyMessage($reply_token,$msg);



	}
		 
 

?>