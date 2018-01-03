<?php
 
 	$thumbnailImageUrl=null;
	 if($redis->checkUserId($user_id)==0){  //no user_id

		$redis->updateUserStatus($user_id,'no_user_id');
		
				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請加入卡好用BOT才能享有此功能唷"); //文字
				$response =  $bot->replyMessage($reply_token, $textMessageBuilder);
		
	}else if($redis->checkLocation($user_id)==0){ //no location
		
		$redis->updateUserStatus($user_id,'no_location');
		
				$originalContentUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/location_desc.png';
				$previewImageUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/location_desc.png';


				$actions = array(
 
						   new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F4CD')." 定位座標", "line://nv/location")
						   );
								   
					
				$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder(emoji('1F50D')." 優惠搜尋","請先點下方選定位座標。", $thumbnailImageUrl,$actions);
				$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);

				$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
		
				$ImageMessageBuilder = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalContentUrl,$previewImageUrl); //文字
				//$Text = new LINE\LINEBot\MessageBuilder\TextMessageBuilder("定位完成以後請再次點選定定位收尋(若想更改座標重新定位)。".emoji('100033'));
				$MultiMessageBuilder->add($msg);
				//$MultiMessageBuilder->add($ImageMessageBuilder);
				//$MultiMessageBuilder->add($Text);
				$bot->replyMessage($reply_token, $MultiMessageBuilder);
		
	}else{

		$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

		$latlng=$redis->getLocation($user_id);
		$zip_code =$redis->getzipcode($user_id);


		$contents = json_decode(file_get_contents("https://www.cardhoin.com/apiserver/deviceapi/v1/geoes/live?zip_code=".$zip_code))->result->geo003->geo;
		
		$area_level_1=$contents->parent->value;
		$area_level_2=$contents->value;

	   $actions = array(
 
		//new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder(emoji('1F50D')." 類別搜尋", "map_cat=Y"),
		//new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder(emoji('1F50D')." 關鍵字搜尋", "map_key=Y"),	
	    new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F4CD')." 更新位置", "line://nv/location")
		);

		$baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'cat_menu.png?_ignore=';
		
				   $altText="卡好用類別";
		
				   $baseSizeBuilder = new LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder(750,1040);
				   $areaBuilderKeyword = new LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(17,46,944,113); 	//LT block
				   $areaBuilderCat1 = new LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(84,211,174,174);	//RT block
				   $areaBuilderCat2 = new LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(319,211,174,174);	//LD block
				   $areaBuilderCat3 = new LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(551,211,174,174);	//RD block
				   $areaBuilderCat4 = new LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(786,211,174,174);	//RD block
				   $areaBuilderCat5 = new LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(84,467,174,174);	//RD block
				   $areaBuilderCat6 = new LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(319,467,174,174);	//RD block
				   $areaBuilderCat7 = new LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(551,467,174,174);	//RD block
				   
				   $linkUri1="關鍵字搜尋";
				   $Cat1="類別：美味食光";
				   $Cat2="類別：購物優惠";
				   $Cat3="類別：影藝娛樂";
				   $Cat4="類別：旅遊住宿";
				   $Cat5="類別：加油租車";
				   $Cat6="類別：交通運輸";
				   $Cat7="類別：網路平台";
		
				   $columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($linkUri1,$areaBuilderKeyword);
				   $columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat1,$areaBuilderCat1);
				   $columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat2,$areaBuilderCat2);
				   $columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat3,$areaBuilderCat3);
				   $columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat4,$areaBuilderCat4);
				   $columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat5,$areaBuilderCat5);
				   $columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat6,$areaBuilderCat6);
				   $columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat7,$areaBuilderCat7);
	   
				   $ImageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder($baseUrl,$altText,$baseSizeBuilder,$columns);  
				   
				   
				
 
	$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder(emoji('1F50D')." 優惠搜尋","目前定位點： ".$area_level_1." ➤ ".$area_level_2."\n若要更改地點請點選更新位置。", $thumbnailImageUrl,$actions);
	$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);
	
	$MultiMessageBuilder->add($msg);	
	$MultiMessageBuilder->add($ImageMessageBuilder);

	$bot->replyMessage($reply_token,$MultiMessageBuilder);	
 

	}
?>