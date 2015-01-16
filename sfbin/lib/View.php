<?php

class View {
	
	public static function go($file, $args = array()) {
		
		require_once _SITEDIR . _SITEVIEWFOLDER . $file . ".php";
		
	}
	
}

?>