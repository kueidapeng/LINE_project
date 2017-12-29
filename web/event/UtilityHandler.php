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
	public function tag_translate($ori_string){
		$pattern_angle = "/\{{(.*?)\}}/"; // remain{{}}
		$pattern_square = "/\{{(.*)\s\w+='(.*)'\}}/"; // deal with{{...}}
													  // Tag content_og_tag																
		// Tag content
		preg_match_all($pattern_angle, $ori_string, $matches_angle);
		foreach ($matches_angle[0] as $angle) {
			preg_match_all($pattern_square, $angle, $matches);
			if (isset($matches[0][0])) {
				$be_replaced[] = $matches[0][0]; // save string be replace
				$replacement[] = $this->{$matches[1][0]}($matches[2][0]); // save replace string
			}
		}
		if (isset($be_replaced) && isset($replacement))
		$Text = str_replace($be_replaced, $replacement, trim($ori_string));
	   return $Text;
	}

}
