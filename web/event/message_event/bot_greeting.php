 <?php
    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("您好!卡好用很開心為您服務^^"); //文字
    $bot->replyMessage($reply_token, $textMessageBuilder);
?>
