<?php
namespace App\event\message_event;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
class ImagemapHandler {

	public function createImagemap() {
     $baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'cat_menu_hand.png?_ignore=';
 
	$altText="卡好用類別";
 
	$baseSizeBuilder = new BaseSizeBuilder(750,1040);
	$areaBuilderKeyword = new AreaBuilder(17,46,944,113); 	//LT block
	$areaBuilderCat1 = new AreaBuilder(84,211,174,174);	//RT block
	$areaBuilderCat2 = new AreaBuilder(319,211,174,174);	//LD block
	$areaBuilderCat3 = new AreaBuilder(551,211,174,174);	//RD block
	$areaBuilderCat4 = new AreaBuilder(786,211,174,174);	//RD block
	$areaBuilderCat5 = new AreaBuilder(84,467,174,174);	//RD block
	$areaBuilderCat6 = new AreaBuilder(319,467,174,174);	//RD block
	$areaBuilderCat7 = new AreaBuilder(551,467,174,174);	//RD block
			
	$linkUri1="關鍵字搜尋";
	$Cat1="類別：美味食光";
	$Cat2="類別：購物優惠";
	$Cat3="類別：影藝娛樂";
	$Cat4="類別：旅遊住宿";
	$Cat5="類別：加油租車";
	$Cat6="類別：交通運輸";
	$Cat7="類別：網購訂票";
 
	$columns[] = new ImagemapMessageActionBuilder($linkUri1,$areaBuilderKeyword);
	$columns[] = new ImagemapMessageActionBuilder($Cat1,$areaBuilderCat1);
	$columns[] = new ImagemapMessageActionBuilder($Cat2,$areaBuilderCat2);
	$columns[] = new ImagemapMessageActionBuilder($Cat3,$areaBuilderCat3);
	$columns[] = new ImagemapMessageActionBuilder($Cat4,$areaBuilderCat4);
	$columns[] = new ImagemapMessageActionBuilder($Cat5,$areaBuilderCat5);
	$columns[] = new ImagemapMessageActionBuilder($Cat6,$areaBuilderCat6);
	$columns[] = new ImagemapMessageActionBuilder($Cat7,$areaBuilderCat7);

        $ImageMessageBuilder = new ImagemapMessageBuilder($baseUrl,$altText,$baseSizeBuilder,$columns); 
	 	return $ImageMessageBuilder;
	 }
   
}
