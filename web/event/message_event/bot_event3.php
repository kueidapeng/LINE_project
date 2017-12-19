 
<?php
			$MultiMessageBuilder = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

		$Text1='3';
		$Text2='2';
		$Text3='1';


 		$rand =rand(1, 10);

		$MultiMessageBuilder->add(new LINE\LINEBot\MessageBuilder\TextMessageBuilder($Text1));
		$MultiMessageBuilder->add(new LINE\LINEBot\MessageBuilder\TextMessageBuilder($Text2));
		$MultiMessageBuilder->add(new LINE\LINEBot\MessageBuilder\TextMessageBuilder($Text3));

  		if($rand>2){
			$MultiMessageBuilder->add(new LINE\LINEBot\MessageBuilder\StickerMessageBuilder(1,15));
			$MultiMessageBuilder->add(new LINE\LINEBot\MessageBuilder\TextMessageBuilder("廢物抽不到吧~顆顆"));
		  }else{

			$originalContentUrl='https://www.pawbo.com/us/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/1/t/1thb_combo.jpg';
			$previewImageUrl='https://www.pawbo.com/us/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/1/t/1thb_combo.jpg';
	 
			$ImageMessageBuilder = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($originalContentUrl,$previewImageUrl); //文字
			$MultiMessageBuilder->add($ImageMessageBuilder);
			$MultiMessageBuilder->add(new LINE\LINEBot\MessageBuilder\TextMessageBuilder("恭喜您獲得波寶一台~"));
		
		}


		$response =  $bot->replyMessage($reply_token, $MultiMessageBuilder);

 
?>
 