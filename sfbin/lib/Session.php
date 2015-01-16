<?php

class Session {
	
	//Creates a session id if not already set
	public static function create_if_unset() {
		
		if(empty($_SESSION[_SFSESSIONNAME])) {
			
			Session::force(Session::generate());
			
		}
		
	}
	
	//Gets the session id, or if not set returns false
	public static function get() {
		
		if(!empty($_SESSION[_SFSESSIONNAME])) {
			
			return $_SESSION[_SFSESSIONNAME];
			
		}
		
		return false;
		
	}
	
	//Generates the session id for use
	public static function generate() {
		
		return md5(session_id() . $_SERVER['REMOTE_ADDR'] . mt_rand());
		
	}
	
	//Force the session id to change to...
	public static function force($session_id) {
		
		$_SESSION[_SFSESSIONNAME] = $session_id;
		
	}
	
}

?>