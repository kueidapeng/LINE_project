 
<?php

		    $columns = array();
			$baseUrl="https://linerobot2.000webhostapp.com/cube.jpg/1040";
			$altText="方塊圖片";
			
			$baseSizeBuilder = new \LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder(1040,1040);
			$areaBuilderLT = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(0,0,520,520); //1
			$areaBuilderRT = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(520,0,520,520);//2
			$areaBuilderLD = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(0,520,520,520);//3
			$areaBuilderRD = new \LINE\LINEBot\ImagemapActionBuilder\AreaBuilder(520,520,520,520);//4
			
			
			$text1="LINE在2016年9月底的「LINE Developer Day 2016」大會上發表了功能性高、且可提供開發人員豐富支援的Messaging API功能。有開發能力的服務提供商即可透過Messaging API將自己的服務內容串聯到LINE@上。對這些服務提供商的好友來說，即可透過LINE聊天介面與該LINE@帳號進行雙向互動，並操作各式線上服務，享用完整、一致的使用者體驗。";
			$text2="你可以在LINE@帳號上開啟Messaging API功能，以打造專屬的LINE聊天機器人。";			
			$linkUri1="https://www.google.com.tw/";
			$linkUri2="https://www.youtube.com/";
			
			$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($text1,$areaBuilderLT);
			$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder($linkUri1,$areaBuilderRT);
			$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder($text2,$areaBuilderLD);
			$columns[] = new \LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder($linkUri2,$areaBuilderRD);

 
			$ImageMessageBuilder = new \LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder($baseUrl,$altText,$baseSizeBuilder,$columns);  
 
			$response =  $bot->replyMessage($reply_token, $ImageMessageBuilder);
 

?>
 