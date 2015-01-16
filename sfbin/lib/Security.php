<?php

class Hash {
	
	public static function make($unenc_string) {
		
		return password_hash($unenc_string, PASSWORD_BCRYPT);
		
	}
	
	public static function verify($unenc_string, $hash) {
		
		return password_verify($unenc_string, $hash);
		
	}
	
}

?>