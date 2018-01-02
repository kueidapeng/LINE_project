 
<?php

 
	$actions = array(
		new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F527')." IOS 版本", "http://bit.ly/FBabout_iOS"),
			new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder(emoji('1F527')." Android 版本", "http://bit.ly/FBabout_Android")
			);
					
 
		$carousel = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder(emoji('1F4F2')." 卡好用APP","選擇您的作業系統", $thumbnailImageUrl,$actions);
		$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要在手機上才能看唷", $carousel);
		$bot->replyMessage($reply_token,$msg);			
?>
 