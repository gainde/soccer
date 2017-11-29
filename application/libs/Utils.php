<?php

/**
 * Description of utils
 *
 * @author Moussa
 */
class Utils {
   
    private static function randomString($length = 50)
    {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
	$string = '';    
		
	for ($p = 0; $p < $length; $p++) {
		$string .= $characters[mt_rand(0, strlen($characters))];
	}
		
      	return $string;
    }


}
