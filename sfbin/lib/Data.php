<?php

class Data {
	
	//Flashes data to the session for one viewing
	public static function flash_once($name, $value) {
		
		$_SESSION["_SFFLASH"][$name] = $value;
		$_SESSION["_SFFLASH"][$name . "_expire"] = 1;
		
	}
	
	//Get flash data
	public static function get_flash($name) {
		
		if(!empty($_SESSION["_SFFLASH"][$name])) {
			
			return $_SESSION["_SFFLASH"][$name];
			
		}
		
		return false;
		
	}
	
	//Clear flash_once data
	public static function clear_flash_once() {
		
		if(empty($_SESSION["_SFFLASH"])) {
			
			return false;
			
		}
		
		foreach($_SESSION["_SFFLASH"] as $key => $session) {
			
			if(strpos($key, "_expire") && $session == 1) {
				
				$_SESSION["_SFFLASH"][$key] = 0;
				
			} elseif(strpos($key, "_expire") && $session == 0) {
				
				unset($_SESSION["_SFFLASH"][str_replace("_expire", "", $key)], $_SESSION["_SFFLASH"][$key]);
				
			}
			
		}
		
	}
	
}

?>