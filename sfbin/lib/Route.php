<?php

//This is the class the user invokes when they define a routing parameter
class Route {
	
	//Listen for URL and allow an open function to respond
	public static function go($url, $user_function) {
		
		$args = Route::url_match_check($url, App::get_routing_url());
		if($args != false) {
			
			if(count($args) == 0) {
				
				call_user_func($user_function);
				
			} else {
				
				call_user_func($user_function, $args);
				
			}
			
			App::$routedestinationfound = true;
			
		}
		
	}
	
	//Listen for URL and route to controller to respond
	public static function go_controller($url, $class, $method, $params = array()) {
		
		$args = Route::url_match_check($url, App::get_routing_url());
		if($args != false) {
			
			//Get class file
			require_once _SITEDIR . _SITECONTROLLERFOLDER . $class . ".php";
			
			//Invoke method
			$obj = new $class;
			if(is_array($args)) {
				
				$params = array_merge($params, $args);
								
			}
				
			call_user_func_array(array($obj, $method), $params);
			App::$routedestinationfound = true;
			
		}
		
	}
	
	//This class is called when the page is not found 404
	public static function page_not_found404($user_function) {
		
		//Determine if anything has been found
		if(App::$routedestinationfound == false) {
			
			call_user_func($user_function);
			
		}
		
	}
	
	public static function url_var_breakdown($url) {
		
		//Check if url contains variable marker
		if(strpos($url, "?")) {
			
			return explode("/", $url);
			
		} else {
			
			return false;
			
		}
		
	}
	
	public static function url_breakdown($url) {
		
		return explode("/", $url);
		
	}
	
	//This method checks if there is a match between two urls taking into the account the possibility of variables
	//It returns either true if the urls are a direct match which means there are no variables
	//False if no match
	//or an array if there is a match and some arguments are variables
	public static function url_match_check($url_route, $url_request) {
		
		if($breakdown_route = Route::url_var_breakdown($url_route)) {
			
			$breakdown_request = Route::url_breakdown($url_request);
			
			//Check if the number of user supplied arguments is not the same as what this route was told to handle, in which case fail
			if(count($breakdown_request) != count($breakdown_route)) {
				
				return false;
				
			}
			
			//Check for a match
			$get_args = array();
			for($i = 0; $i <= count($breakdown_request) - 1; $i ++) {
				
				//Check if this request matches the available routes, accounting for possible variables
				if(substr($breakdown_route[$i], 0, 1) == "?") {
					
					//The route specifies that this parameter accepts a variable
					$get_args[substr($breakdown_route[$i], 1)] = $breakdown_request[$i];
					
				} elseif($breakdown_route[$i] != $breakdown_request[$i]) {
					
					return false;
					
				}
				
			}
			
			return $get_args;
			
		} elseif($url_request == $url_route) {
			
			return true;
			
		}
		
	}
	
}

?>