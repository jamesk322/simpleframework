<?php

class process_user {
	
	//Call login model to attempt to log the user in
	public function login() {
		
		if(Model::get("user")->login()) {
			
			Data::flash_once("just_logged_in", "true");
			Redirect::go("");
			
		} else {
			
			Data::flash_once("login_attempt", "fail");
			Redirect::go("login");
			
		}
		
		
	}
	
}

?>