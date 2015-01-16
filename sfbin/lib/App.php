<?php

class App {
	
	//Detect if routing destination was found
	public static $routedestinationfound = false;
	
	public static function run() {
		
		//Create an object of this class for the runtime
		$runtime = new App();
		
		//Begin session
		$runtime->session();
		
		//Begin routing
		$runtime->route();	
		
		//Cleanup
		$runtime->cleanup();
		
	}
	
	//Get the routing URL without all the extra bits for the routing system
	public static function get_routing_url() {
		
		$_sf_appurl_nouri = str_replace(_APPFOLDER, "", $_SERVER['REQUEST_URI']);
		if(strpos("$_sf_appurl_nouri", "?")) {
			
			return substr($_sf_appurl_nouri, 0, strpos($_sf_appurl_nouri, "?"));
			
		} else {
			
			return $_sf_appurl_nouri;
			
		}
		unset($_sf_appurl_nouri);
		
	}
	
	//Set session data
	public function session() {
		
		session_start();
		Session::create_if_unset();
		
	}
	
	//Begin running the route system
	public function route() {
		
		//Get the user created route file which automatically will then generate results
		require_once _SFDIR . "route.php";
		
		//Get the status codes file to catch status codes (errors ect.)
		require_once _SFDIR . "status_codes.php";
		
	}
	
	//Clears unwanted flash vars
	public function cleanup() {
		
		Data::clear_flash_once();
		
	}
	
}

?>