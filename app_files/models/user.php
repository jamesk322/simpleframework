<?php

class user {
	
	public function login() {
		
		$res = DB::query("select `user_id`, `password` from `users` where `username`=? limit 0, 1", array($_POST["username"]));
		while($row = $res->fetch_assoc()) {
			
			//Check if password supplied matches
			if(Hash::verify($_POST["password"], $row["password"])) {
				
				//Set session data
				$session_id = Session::generate();
				Session::force($session_id);
				DB::query("update users set session_id='" . $session_id . "' where `user_id`=" . $row["user_id"]);
				
				//Clear any failed attempts
				DB::query("update `users` set `failed_login_attempts` = 0 where `user_id`=" . $row["user_id"]);
			
				
				return true;
				
			}
			
			//Mark the failed attempt
			DB::query("update `users` set `failed_login_attempts` = `failed_login_attempts` + 1 where `user_id`=" . $row["user_id"]);
			
		}
		
		//Login failed
		return false;
		
	}
	
	//Gets the data of the user logged in, or returns false if no user is logged in
	public function get_user() {
		
		$res = DB::query("select * from `users` where `session_id`='" . Session::get() . "' limit 0, 1");
		if($res->num_rows > 0) {
			
			return $res->fetch_assoc();
			
		}
		
		return false;
		
	}
	
	//Detect if the user has just logged in and this is the first page they are viewing
	public function detect_just_logged_in() {
		
		//Build just logged in message
		if(Data::get_flash("just_logged_in")) {
			
			return true;
			
		}
		
		return false;
		
	}
	
	//Deny the requested page when a user does not have the correct permissions to view it
	public function handle_invalid_perms() {
		
		//Check if the user is not logged in and redirect to login page
		if(!Model::get("user")->get_user()) {
			
			Redirect::go("login");
			
		}
		
	}
	
}

?>