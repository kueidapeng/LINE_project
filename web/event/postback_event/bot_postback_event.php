<?php
			/*
			post event
			*/
			
			$getText = $event->getPostbackData();
			
			if ($getText) {
				parse_str($getText, $data);
				if (isset($data["map_key"])) {
					
					$page = $data["map_key"];

					switch ($page) {
						case 'Y':
						include('event/message_event/bot_map_search.php');
						break;
						case 'N':
						include('event/message_event/bot_imagemap.php');
						break;				
					}

				}
				if (isset($data["map_cat"])) {
					
					$page = $data["map_cat"];

					switch ($page) {
						case 'Y':
						include('event/message_event/bot_map_search.php');
						break;
						case 'N':
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