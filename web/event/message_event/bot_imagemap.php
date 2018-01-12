 <?php
    	   $redis->updateUserStatus($user_id,'');
		   $imagemap= new App\event\message_event\ImagemapHandler;				//create imagemap object
		   $ImageMessageBuilder=$imagemap->createImagemap();
		   $response =  $bot->replyMessage($reply_token, $ImageMessageBuilder);
 ?>
 