<?php

class process_ajax {
	
	//Initial calling point for this class, this will then forward the ajax request to the correct method
	public function auto_detect($args) {
		
		//Check if the method requested by the user is safe to be called
		$safe_methods = array("change_appointment_status", "search_patients", "load_patient_record", "patient_new_note", "update_note", "autosave_note", "get_last_autosave_stamp", "get_patient_id_from_appointment");
		if(in_array($args, $safe_methods)) {
			
			call_user_func(array($this, $args));
			
		}
		
		return false;
		
	}
	
	//Process the user input to change the appointment status
	public function change_appointment_status() {
		
		//Remove any unusable text in the ids and convert to just the id
		$appointment_id = str_replace("appointment_", "", $_GET["appointment_id"]);
		switch($_GET["change_to_status_id"]) {
			
			case "begin_patient":
			
				$status_id = 1;
				
			break;
			case "cancel_patient":
			
				$status_id = 4;
				
			break;
			
		}
		
		//If the status is anything other than cancel, begin to change status, otherwise use the specific cancel appointment method
		if($status_id != 4) {
			
			Model::get("appointments")->change_appointment_status($appointment_id, $status_id);
			
		} else {
			
			//Cancel appointment
			Model::get("appointments")->cancel_appointment($appointment_id, $_GET["cancel_patient_reason"], Model::get("user")->get_user()["user_id"]);
			Model::get("appointments")->change_appointment_status($appointment_id, $status_id);
			
		}
		
	}
	
	//Search patient records
	public function search_patients() {
		
		$search_results = Model::get("patient")->find(array("lastname" => $_GET["lastname"]), "json");
		if($search_results) {
			
			print_r($search_results);
			
		} else {
			
			//Return nothing to the DOM
			print_r(json_encode(array()));
			
		}
		
	}
	
	//Load patient record
	public function load_patient_record() {
		
		View::go("patient_record", array("patient_id" => $_GET["patient_id"]));
		
	}
	
	//Load new patient note
	public function patient_new_note() {
		
		$db_insert_id = Model::get("patient")->create_new_note_placeholder($_GET["patient_id"], Model::get("user")->get_user()["user_id"]);
		View::go("patient_new_note", array("patient_id" => $_GET["patient_id"], "db_insert_id" => $db_insert_id));
		
	}
	
	//Update a patients note
	public function update_note() {
		
		if(Model::get("patient")->update_note($_GET["db_insert_id"], array("data" => $_POST["note_data"], "data_summary" => $_POST["patient_note_summary"]))) {
			
			echo "ID: " . $_GET["db_insert_id"] . " updated with, <pre>" . $_POST["note_data"] . "</pre>";
			
		}
		
	}
	
	//Autosave a patients note
	public function autosave_note() {
		
		Model::get("patient")->update_note($_POST["db_insert_id"], array("data_autosave" => $_POST["data_autosave"]));
		
	}
	
	//Get the last autosave stamp for a specific note id
	public function get_last_autosave_stamp() {
		
		$autosave_stamp = Model::get("patient")->get_medical_notes(array("note_id" => $_GET["db_insert_id"]))["results"][0]["stamp_autosave"];
		
		if($autosave_stamp != "0000-00-00 00:00:00") {
			
			echo date_format(date_create($autosave_stamp), "jS M y H:i");
			
		} else {
			
			echo "false";
			
		}
		
	}
	
	public function get_patient_id_from_appointment() {
		
		echo Model::get("appointments")->get_appointment($_GET["appointment_id"])["patient_id"];
		
	}
	
}

?>