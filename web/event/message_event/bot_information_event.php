<?php
    use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
    use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
    use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
    use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
    use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;

    $columns = array();
    $MultiMessageBuilder = new MultiMessageBuilder();
    $policy_url='https://www.cardhoin.com/policy';
    $instagram_url='https://www.instagram.com/cardhoin.app/';
    $facebook_url='https://www.facebook.com/cardhoin/';
    $baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'certificate_new.png?_ignore=';			
    //policy
    $actions = array( new UriTemplateActionBuilder(emoji('1F449')." 服務條款連結",$policy_url) );
    $column = new CarouselColumnTemplateBuilder('服務條款','卡好用為宏碁資訊服務股份有限公司所研發...',$baseUrl, $actions);
    $columns[] = $column;	
    //instagram
    $baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'instagram_logo.png?_ignore=';			
    $actions = array( new UriTemplateActionBuilder(emoji('1F449')." instagram連結",$instagram_url) );
    $column = new CarouselColumnTemplateBuilder('instagram','卡好用 instagram',$baseUrl, $actions);
    $columns[] = $column;	
    //facebook
    $baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'facebook.png?_ignore=';			
    $actions = array( new UriTemplateActionBuilder(emoji('1F449')." facebook連結",$facebook_url) );
    $column = new CarouselColumnTemplateBuilder('facebook','卡好用 facebook',$baseUrl, $actions);
    $columns[] = $column;

    $carousel = new CarouselTemplateBuilder($columns);
	$msg = new TemplateMessageBuilder(emoji('1F50D')."這訊息要在手機上才能看唷", $carousel);
	$MultiMessageBuilder->add($msg);
    $bot->replyMessage($reply_token,$MultiMessageBuilder);	
?>