<?php
namespace App\event;

class UtilityHandler {

	public static function toBoolean($value) {
	 	if ($value === null || $value == '')
	 		return false;
	 	return ($value == 0) ? false : true;
	 }
   
}
