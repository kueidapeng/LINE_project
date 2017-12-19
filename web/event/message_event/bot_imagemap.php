 <?php

			$columns = array();
			$baseUrl='https://'. $_SERVER['HTTP_HOST'].'/line_bot/image/menu.png?_ignore=';
			//error_log('1.$baseUrl: '.$baseUrl);
			//error_log('2.$profile: '.$profile);

			$altText="卡好用menu";

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
 
			$ImageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder($baseUrl,$altText,$baseSizeBuilder,$columns);  
 
			$response =  $bot->replyMessage($reply_token, $ImageMessageBuilder);
 

?>
 