<?php
			/*
			location event
			*/
			
			if($redis->checkLocation($user_id)==0){ // location add
				$result_Location=$redis->addUserLocation($user_id,$event->getLatitude(),$event->getLongitude());
				
				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("所在座標已新增".emoji('10008F')); //文字
				$response =  $bot->replyMessage($reply_token, $textMessageBuilder);
			}else{ // location update	
				$result_Location=$redis->updateUserLocation($user_id,$event->getLatitude(),$event->getLongitude());

				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("所在座標已更新".emoji('10008F')); //文字
				$response =  $bot->replyMessage($reply_token, $textMessageBuilder);
			}
			
?>			