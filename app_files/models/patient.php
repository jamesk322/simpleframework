<?php

class patient {
	
	//Query the patients for a match
	public function find($args, $data_format = "array") {
		
		//Determine the search query for the patients table
		$patients_table_search_query["sql"] = "";
		$patients_table_search_query["data"] = "";
		if(!empty($args["patient_id"])) {
			
			$patients_table_search_query["sql"] = "patient_id=?";
			$patients_table_search_query["data"] = $args["patient_id"];
			
		} elseif(!empty($args["lastname"])) {
			
			$patients_table_search_query["sql"] = "last_name like ?";
			$patients_table_search_query["data"] = $args["lastname"] . "%";
			
		}
		
		$patients_array = array();
		
		$res = DB::query("select * from patients where " . $patients_table_search_query["sql"], array($patients_table_search_query["data"]));
		while($row = $res->fetch_assoc()) {
			
			array_push($patients_array, $row);
			
		}
		
		//Check if search returned no results
		if(empty($patients_array)) {
			
			return false;
			
		}
		
		//Return the data in the correct format
		if($data_format == "json") {
			
			return json_encode($patients_array);
			
		} elseif($data_format == "array") {
			
			return $patients_array;
		
		}
				
	}
	
	//Get medical notes
	//Can be searched by patient_id (for all results of the patient), note_id (for just the individual notes)
	public function get_medical_notes($search_terms, $data_format = "array") {
		
		//Build the sql query
		$sql_query["sql"] = "";
		$sql_query["data"] = "";
		if(!empty($search_terms["patient_id"])) {
			
			$sql_query["sql"] = "patient_id=?";
			$sql_query["data"] = $search_terms["patient_id"];
			
		} elseif(!empty($search_terms["note_id"])) {
			
			$sql_query["sql"] = "note_id=?";
			$sql_query["data"] = $search_terms["note_id"];
			
		} else {
			
			//Failed, no correct search terms were provided
			return false;
			
		}
		
		$medical_notes_array = array();
		$res = DB::query("select medical_notes.*, users.display_name from medical_notes left join users on medical_notes.created_by_id=users.user_id where medical_notes." . $sql_query["sql"] . " order by medical_notes.stamp_created desc", array($sql_query["data"]));
		while($row = $res->fetch_assoc()) {
			
			$medical_notes_array["results"][] = $row;
			
		}
		
		$medical_notes_array["num_rows"] = $res->num_rows;
		
		//Check if search returned no results
		if(empty($medical_notes_array)) {
			
			return false;
			
		}
		
		//Return the data in the correct format
		if($data_format == "json") {
			
			return json_encode($medical_notes_array);
			
		} elseif($data_format == "array") {
			
			return $medical_notes_array;
		
		}
		
	}
	
	//Create a new note for a patient (placeholder only)
	public function create_new_note_placeholder($patient_id, $user_id) {
		
		//Check if patient exists
		if(!$this->find(array("patient_id" => $patient_id))) {
			
			return false;
			
		}
		
		//Insert into database
		$db_connection = DB::connect();
		DB::query("insert into medical_notes (patient_id, created_by_id, stamp_created) values (?, ?, NOW())", array($patient_id, $user_id), $db_connection);
		$insert_id = $db_connection->insert_id;
		DB::close($db_connection);
		return $insert_id;
		
	}
	
	//Update a note
	public function update_note($note_id, $args) {
		
		//This method accepts an array of arguments that represent the fields to be updated
		
		//Check if note does not exist
		if(!$this->get_medical_notes(array("note_id" => $note_id))) {
			
			return false;
			
		}
		
		//Great, note does exist so get started building the update
		
		//Get existing data
		$note = $this->get_medical_notes(array("note_id" => $note_id))["results"][0];
		
		//Build the query
		if(empty($args["data"])) {
			
			$args["data"] = $note["data"];
			
		}
		if(empty($args["data_summary"])) {
			
			$args["data_summary"] = $note["data_summary"];
			
		}
		if(empty($args["data_autosave"])) {
			
			$args["data_autosave"] = "";
			$args["stamp_autosave"] = "'0000-00-00 00:00:00'";
			
		} elseif(!empty($args["data_autosave"])) {
			
			$args["stamp_autosave"] = "NOW()";
			
		}
		
		//Update the database
		DB::query("update medical_notes set data=?, data_summary=?, data_autosave=?, stamp_autosave=" . $args["stamp_autosave"] . " where note_id=?", array($args["data"], $args["data_summary"], $args["data_autosave"], $note_id));
		
		return true;
		
	}
	
}

?>