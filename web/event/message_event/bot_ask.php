<?php
    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("您好!請問您的問題什麼呢?"); //文字
    $bot->replyMessage($reply_token, $textMessageBuilder);
?>
