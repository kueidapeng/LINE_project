 
<?php

		    $columns = array();
			$baseUrl="https://4.share.photo.xuite.net/min0427/140d536/6411593/262027757_x.jpg";
			$altText="方塊圖片";
			
			$baseSizeBuilder = new \LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder(1040,1040);
			$areaBuilderLT = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(0,0,520,520); //1
			$areaBuilderRT = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(520,0,520,520);//2
			$areaBuilderLD = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(0,520,520,520);//3
			$areaBuilderRD = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(520,520,520,520);//4
			
			
			 $text1="block1";
			//$text2="block2";			
			$linkUri1="https://www.google.com.tw/";
			//$linkUri2="https://www.youtube.com/";
			
			 $columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($text1,$areaBuilderLT);
			$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder($linkUri1,$areaBuilderRT);
			//$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($text2,$areaBuilderLD);
			//$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder($linkUri2,$areaBuilderRD);

 
			$ImageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder($baseUrl,$altText,$baseSizeBuilder,$columns);  
 
			$response =  $bot->replyMessage($reply_token, $ImageMessageBuilder);
 

?>
 