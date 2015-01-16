<?php

class URLHelpers {
	
	//Frontend helpers get the full link for public frontend files
	public static function frontend($file_name) {
		
		return str_replace("\\", "/", "http://" . _BASEURL . _APPFOLDER . _APP_FILES . _SITEFRONTENDFOLDER . $file_name);
		
	}
	
	//URL helper gets the full URL which will direct to a route
	public static function url($url) {
		
		return  "http://" . _BASEURL . _APPFOLDER . $url;
		
	}
	
}

class Redirect {
	
	public static function go($url) {
		
		header("Location: " . URLhelpers::url($url));
		
	}
	
}

?>