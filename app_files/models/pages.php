<?php

class pages {
	
	public $doctor_cp = array("Dashboard" => "doctor_dash", "Patient Records" => "patient_records_search", "Calendar" => "item2");
	
	//Generate the side navigation array for the control panel
	public function generate_side_navigation_array() {
		
		return $this->doctor_cp;
		
	}
	
}

?>