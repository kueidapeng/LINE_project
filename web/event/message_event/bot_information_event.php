<?php
    use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
    use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
    use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
    use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
    use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
    use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
    use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
 
    $MultiMessageBuilder = new MultiMessageBuilder();
    $policy_url='https://www.cardhoin.com/policy';
    $instagram_url='https://www.instagram.com/cardhoin.app/';
    $facebook_url='https://www.facebook.com/cardhoin/';
    //tutor
    $baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'guideV1.png?_ignore=';	
    $actions = array( new MessageTemplateActionBuilder(emoji('1F449')." 使用教學","使用教學"), 
                      new MessageTemplateActionBuilder(" "," ") );
    $column = new CarouselColumnTemplateBuilder('使用教學','卡好用Chat Bot使用步驟教學',$baseUrl, $actions);
    $columns[] = $column;	
    //policy
    $baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'certificateV1.png?_ignore=';			
    $actions = array( new UriTemplateActionBuilder(emoji('1F449')." 服務條款連結",$policy_url), 
                      new MessageTemplateActionBuilder(" "," ") );
    $column = new CarouselColumnTemplateBuilder('服務條款','卡好用為宏碁資訊服務股份有限公司所研發...',$baseUrl, $actions);
    $columns[] = $column;	
    //facebook+instagram
    $baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'informationV1.png?_ignore=';			
    $actions = array(new UriTemplateActionBuilder(emoji('1F449')." facebook連結",$facebook_url),
                     new UriTemplateActionBuilder(emoji('1F449')." instagram連結",$instagram_url));
    $column = new CarouselColumnTemplateBuilder('卡好用相關連結','卡好用相關資訊連結',$baseUrl, $actions);
    $columns[] = $column;

    $carousel = new CarouselTemplateBuilder($columns);
	$TemplateMessageBuilder = new TemplateMessageBuilder(emoji('1F50D')."這訊息要在手機上才能看唷", $carousel);
    $bot->replyMessage($reply_token,$TemplateMessageBuilder);	
?>