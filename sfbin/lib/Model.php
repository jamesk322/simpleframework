<?php

class Model {
	
	//This will load the correct class file and return the class object
	public static function get($class) {
		
		require_once _SITEDIR . _SITEMODELFOLDER . $class . ".php";
		return new $class;
		
	}
	
}

?>