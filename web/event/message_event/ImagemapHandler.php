<?php
namespace App\event\message_event;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
class ImagemapHandler {

	public function createImagemap() {
        $columns = array();
        $baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'line_menu.png?_ignore=';
        $altText="卡好用LINE服務";
        
        $baseSizeBuilder = new BaseSizeBuilder(1040,1040);
        $areaBuilderLT = new AreaBuilder(17,215,500,400); 	//LT block
        $areaBuilderRT = new AreaBuilder(523,210,500,400);	//RT block
        $areaBuilderLD = new AreaBuilder(17,623,500,400);	//LD block
        $areaBuilderRD = new AreaBuilder(523,623,500,400);	//RD block

        $linkUri1="https://www.cardhoin.com/category/today?offset=10";
        $linkUri2="https://www.cardhoin.com/category/hot?offset=10";
        $linkUri3="https://www.cardhoin.com/category/new?offset=10";
        $linkUri4="座標優惠搜尋";

        $columns[] = new ImagemapUriActionBuilder($linkUri1,$areaBuilderLT);
        $columns[] = new ImagemapUriActionBuilder($linkUri2,$areaBuilderRT);
        $columns[] = new ImagemapUriActionBuilder($linkUri3,$areaBuilderLD);
        $columns[] = new ImagemapMessageActionBuilder($linkUri4,$areaBuilderRD);

        $ImageMessageBuilder = new ImagemapMessageBuilder($baseUrl,$altText,$baseSizeBuilder,$columns);  
	 	return $ImageMessageBuilder;
	 }
   
}
