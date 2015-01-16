var current_selected_appointment = "";
function select_appointment(appointment_id) {
	
	//Clear previous selections
	$(".appointment_tr").css("background-color", "transparent");
	
	//Check if user is deselecting
	if(appointment_id == current_selected_appointment) {
		
		//Hide controls
		current_selected_appointment = "";
		$("#appointment_actions").hide();
		
	} else {
		
		//Select clicked
		$("#" + appointment_id).css("background-color", "#C4FFC4");
		current_selected_appointment = appointment_id;
		
		//Display controls
		$("#appointment_actions").show();
	
	}
	
}

function process_appointment_status_change(change_to_status_id, place_content_in) {
	
	//Check if the action is to cancel the patient and prompt the user for more information
	if(change_to_status_id == "cancel_patient") {
		
		$("#cancel_appointment_dialog").removeClass("modal hide").addClass("modal show");
		
		//Wait for continue click 
		$("#cancel_appointment_bu").click(function() {make_appointment_status_change(change_to_status_id, place_content_in);});
		
	} else {
		
		make_appointment_status_change(change_to_status_id, place_content_in);
		
	}
	
}

function make_appointment_status_change(change_to_status_id, place_content_in) {
	
	//Build cancel patient args if the user is trying to cancel the appointment
	cancel_patient_args = "";
	if(change_to_status_id == "cancel_patient") {
		
		cancel_patient_args = "&cancel_patient_reason=" + $("#cancel_patient_reason").val();
		
	}
	
	$.when(load_sub_content("process/ajax/change_appointment_status?appointment_id=" + current_selected_appointment + "&change_to_status_id=" + change_to_status_id + cancel_patient_args, place_content_in)).done(setTimeout(function() {load_content("doctor_dash");}, 1000));
	
	current_selected_appointment = "";
	
}

function refresh_appointments() {
	
	//Refresh the appointments
		
	var appointment_refresh_timer = setTimeout(function() {
		
		if(sidebar_tab_selected == "#li_doctor_dash") {
			
			//Check that no appointments are selected and the DOM is free to have the appointments refreshed
			if(current_selected_appointment == "") {
				
				load_content("doctor_dash");
				
			}
		
		}
		
		refresh_appointments();
		
	}, 10000);
	
}