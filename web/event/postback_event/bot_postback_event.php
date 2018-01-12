<?php
use LINE\LINEBot\MessageBuilder\TextMessageBuilder as TextMessageBuilder;
			/*
			post event
			*/
			$UtilityHandler= new App\event\UtilityHandler;				//create UtilityHandler object
			$jsonString=$UtilityHandler->getJsonString();				//get json string from description

			$getText = $event->getPostbackData();
			
			if ($getText) {
				parse_str($getText, $data);
				if (isset($data["map_key"])) {
					
					$page = $data["map_key"];

					switch ($page) {
						case 'Y':
						$bot->pushMessage($user_id, new TextMessageBuilder($jsonString['bot_postback_event_continue_search'])); //message push
						include('event/message_event/bot_map_search_key.php');
						break;
						case 'N':
						$bot->pushMessage($user_id, new TextMessageBuilder($jsonString['bot_postback_event_cardhoin_service'])); //message push
						include('event/message_event/bot_imagemap.php');
						break;				
					}

				}
				if (isset($data["map_cat"])) {
					
					$page = $data["map_cat"];
						
					switch ($page) {
						case 'Y':
						$bot->pushMessage($user_id, new TextMessageBuilder($jsonString['bot_postback_event_continue_search'])); //message push
						include('event/message_event/bot_map_search.php');
						break;
						case 'N':
						$bot->pushMessage($user_id, new TextMessageBuilder($jsonString['bot_postback_event_cardhoin_service'])); //message push
						include('event/message_event/bot_imagemap.php');
						break;				
					}

				}

				if (isset($data["map_cat_name"])) {
 
					$Text= $data["map_cat_name"];
					include('event/message_event/bot_category.php');

				}				
			}
			
?>			