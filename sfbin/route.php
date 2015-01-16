<?php

Route::go("", function() {
	
	Model::get("user")->handle_invalid_perms();
	View::go("index");
	
});

Route::go("login", function() {
	
	View::go("login");
	
});

Route::go_controller("process/login" , "process_user", "login");

Route::go("doctor_dash", function() {
	
	Model::get("user")->handle_invalid_perms();
	View::go("doctor_dash");
	
});

Route::go("patient_records_search", function() {
	
	Model::get("user")->handle_invalid_perms();
	View::go("patient_records_search");
	
});

//Route for all ajax process methods, this routes through an auto detect which will determine the correct forwarding method
Route::go_controller("process/ajax/?action", "process_ajax", "auto_detect");

//Route for the file uploader
Route::go_controller("process/upload", "process_upload", "upload");

/*
**
** UNIT TESTING ONLY!
**
**
*/
Route::go("UnitTesting", function() {
	
	print_r($_SESSION);
	
});

?>