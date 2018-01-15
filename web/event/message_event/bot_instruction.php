<?php
    use  LINE\LINEBot\MessageBuilder\TextMessageBuilder;
    use  LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
    use  LINE\LINEBot\MessageBuilder\ImageMessageBuilder;

    $MultiMessageBuilder = new MultiMessageBuilder();
    $baseUrl='https://'. $_SERVER['HTTP_HOST'].getenv('image_path').'menu_instructionV1.png?_ignore=';	

    $MultiMessageBuilder->add(new TextMessageBuilder(emoji('2728').' 若您欲輸入關鍵字查詢店家，請點擊圖片中「關鍵字查詢」欄位進行查詢。'."\r\n".emoji('2728').' 若想快速查詢可點擊下方的「分類圖示」進行查詢。'));
    $MultiMessageBuilder->add(new ImageMessageBuilder($baseUrl,$baseUrl));
    
	$bot->replyMessage($reply_token, $MultiMessageBuilder);


