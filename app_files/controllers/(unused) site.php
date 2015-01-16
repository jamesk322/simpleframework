<?php

class site {
	
	public $doctor_cp = array("Dashboard" => "doctor_dash", "Patient Records" => "item1", "Calendar" => "item2");
	
	//Controller for loading the index page
	public function index() {
		
		//User is logged in, continue...
		//Build args for view...
		$args = array();
		//Build user data
		array_push($args, Model::get("user")->get_user());
		//Build sidebar
		array_push($args, $this->generate_side_navigation());
		//Build javascript
		array_push($args, $this->generate_js());
		//Build just logged in message
		if(Data::get_flash("just_logged_in")) {
			
			array_push($args, "just_logged_in_true");
			
		} else {
			
			array_push($args, "just_logged_in_false");
			
		}
		
		View::go("index", $args);
		
	}
	
	//Generate the side navigation for the control panel
	public function generate_side_navigation() {
		
		$nav_build = "";
		foreach($this->doctor_cp as $key => $value) {
			
			$nav_build .= "<li id=\"li_" . $value . "\"><a href=\"#\"><i class=\"icon-chevron-right\"></i> " . $key . "</a></li>";
			
		}
		
		return $nav_build;
		
	}
	
	//Generate javascript
	public function generate_js() {
		
		$js_build = "";
		foreach($this->doctor_cp as $key => $value) {
			
			$js_build .= "$( \"#li_" . $value . "\" ).click(function(){load_content(\"" . $value . "\");});" ;
			
		}
		
		return $js_build;
		
	}
	
}

?>