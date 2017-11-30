 
<?php

		    $columns = array();
			$baseUrl="https://raw.githubusercontent.com/chliwei199/images/master/cube.png";
			$altText="方塊圖片";
			
			$baseSizeBuilder = new \LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder(500,500);
			$areaBuilderLT = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(0,0,250,250); //1
			$areaBuilderRT = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(250,0,250,250);//2
			$areaBuilderLD = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(0,250,250,250);//3
			$areaBuilderRD = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(250,250,250,250);//4
			
			
			//$text1="block1";
			//$text2="block2";			
			//$linkUri1="https://www.google.com.tw/";
			//$linkUri2="https://www.youtube.com/";
			
			//$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($text1,$areaBuilderLT);
			$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder($linkUri1,$areaBuilderRT);
			//$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($text2,$areaBuilderLD);
			//$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder($linkUri2,$areaBuilderRD);

 
			$ImageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder($baseUrl,$altText,$baseSizeBuilder,$columns);  
 
			$response =  $bot->replyMessage($reply_token, $ImageMessageBuilder);
 

?>
 