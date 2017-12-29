<?php
namespace App\event;

class UtilityHandler {

	public static function toBoolean($value) {
	 	if ($value === null || $value == '')
	 		return false;
	 	return ($value == 0) ? false : true;
	 }
	 public function getJsonString() {
		$stream = fopen('description.json', 'r');
		$listener = new \JsonStreamingParser\Listener\InMemoryListener();
		try {
 			 $parser = new \JsonStreamingParser\Parser($stream, $listener);
  			 $parser->parse();
  			fclose($stream);
			} catch (Exception $e) {
 		 	fclose($stream);
  			throw $e;
		}
		return $listener->getJson();
	}
	public function emoji($ID){
		$bin = hex2bin(str_repeat('0', 8 - strlen($ID)) . $ID);
	   $emoticon =  mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
	   return $emoticon;
	}

}
