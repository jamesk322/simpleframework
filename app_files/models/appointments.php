<?php

class appointments {
	
	//Gets an array of the upcoming appointments, with an optional limit of how many to display
	public function get_upcoming_appointments($limit = false) {
		
		$appointments_array = array();
		
		$res = DB::query("select appointments.*, patients.*, appointment_types.*, appointment_status_types.* from `appointments` left join patients on patients.patient_id=appointments.patient_id left join appointment_types on appointments.appointment_type_id=appointment_types.appointment_type_id left join appointment_status_types on  appointments.appointment_status_type_id=appointment_status_types.appointment_status_id where appointments.end_stamp > NOW()");
		while($row = $res->fetch_assoc()) {
			
			array_push($appointments_array, $row);
			
		}
		
		return $appointments_array;
		
	}
	
	//Changes the appointment status
	public function change_appointment_status($appointment_id, $status_id) {
		
		DB::query("update appointments set appointment_status_type_id=? where appointment_id=?", array($status_id, $appointment_id));
		
	}
	
	//Cancel appointment
	public function cancel_appointment($appointment_id, $cancel_reason, $cancel_by_user_id) {
		
		DB::query("update appointments set cancelled_by_user_id=?, cancelled_reason=?, cancelled_stamp=NOW() where appointment_id=?", array($cancel_by_user_id, $cancel_reason, $appointment_id));
		
	}
	
	//Get the details of an appointment
	public function get_appointment($appointment_id) {
		
		$res = DB::query("select * from appointments where appointment_id=? limit 0, 1", array($appointment_id));
		while($row = $res->fetch_assoc()) {
			
			return $row;
			
		}
		
	}
	
}

?>