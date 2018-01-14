<?php
    use  LINE\LINEBot\MessageBuilder\TextMessageBuilder;
    use  LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
    use  LINE\LINEBot\MessageBuilder\ImageMessageBuilder;

    $MultiMessageBuilder = new MultiMessageBuilder();
    $baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'guide.png?_ignore=';	

    $MultiMessageBuilder->add(new TextMessageBuilder('test'));
    $MultiMessageBuilder->add(new ImageMessageBuilder($baseUrl,$baseUrl));
    
	$bot->replyMessage($reply_token, $MultiMessageBuilder);


