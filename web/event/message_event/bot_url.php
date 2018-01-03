<?php 


if($getText=='本日優惠'){
  $textMessage = emoji('10008A').' 本日優惠的連結 ： https://www.cardhoin.com/category/today?offset=10';
  }else if($getText=='熱門優惠'){
    $textMessage =emoji('10008A').' 熱門優惠的連結 ： https://www.cardhoin.com/category/hot?offset=10';
  }else if($getText=='最新上架'){
    $textMessage = emoji('10008A').' 最新上架的連結 ： https://www.cardhoin.com/category/new?offset=10';
  }


$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textMessage); 

$response =  $bot->replyMessage($reply_token, $textMessageBuilder);