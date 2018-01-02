<?php
 
		/*
			location search cat message
		*/ 
 
 		$redis->updateUserStatus($user_id,'');

		/*$contents = json_decode(file_get_contents("https://www.cardhoin.com/apiserver/deviceapi/v1/categories?page_type=menu"))->result->cat001->categories;
				$columns = array();
				foreach($contents as $content){

					$img_src="https://". $_SERVER['HTTP_HOST']."/line_bot/image/".$content->category_code.".png";

					$actions = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder(emoji('2B50').$content->name,'map_cat_name='.$content->name);

							$column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder($img_src, $actions);
							$columns[] = $column;
			
					
				}
			*/
			$baseUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/cat_menu.png?_ignore=';
 
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
			$Cat1=emoji('100054')."類別：美味食光";
			$Cat2=emoji('100072')."類別：購物優惠";
			$Cat3=emoji('10003B')."類別：影藝娛樂";
			$Cat4=emoji('1000B5')."類別：旅遊住宿";
			$Cat5=emoji('100053')."類別：加油租車";
			$Cat6=emoji('100047')."類別：交通運輸";
			$Cat7=emoji('10003D')."類別：網路平台";
 
			$columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($linkUri1,$areaBuilderKeyword);
			$columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat1,$areaBuilderCat1);
			$columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat2,$areaBuilderCat2);
			$columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat3,$areaBuilderCat3);
			$columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat4,$areaBuilderCat4);
			$columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat5,$areaBuilderCat5);
			$columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat6,$areaBuilderCat6);
			$columns[] = new LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($Cat7,$areaBuilderCat7);

			$ImageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder($baseUrl,$altText,$baseSizeBuilder,$columns);  
			
			$response =  $bot->replyMessage($reply_token, $ImageMessageBuilder);
		
?>