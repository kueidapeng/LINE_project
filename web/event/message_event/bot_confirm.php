<?php 

$actions = array(
  new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("是", "ans=Y"),
  new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("否", "ans=N")
);
$button = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder("問題", $actions);
$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要用手機的賴才看的到哦", $button);
$bot->replyMessage($reply_token,$msg);