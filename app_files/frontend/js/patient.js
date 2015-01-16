function show_advanced_search() {
	
	$("#advanced_search_terms").show();
	
}

function process_patient_search() {
	
	var lastname = $("#patient_search_lastname").val();
	
	//Check that something has been provided in order to continue
	if(lastname.length >= 3) {
		
		//Search may continue...
		
		load_sub_content("process/ajax/search_patients?lastname=" + lastname, "@generate_patient_search_results");
		
	}
	
}

function generate_patient_search_results(data) {
	
	//Build the results in the DOM
	var results_output = "";
	
	var results_obj = jQuery.parseJSON(data);
	
	for(i = 0; i < results_obj.length; i ++) {
		
		results_output += "<tr class=\"patient_selector_tr\" patient_id=\"" + results_obj[i].patient_id + "\"><td>" + results_obj[i].patient_id + "</td><td>" + results_obj[i].title + " " + results_obj[i].last_name + ", " + results_obj[i].first_name + " " + results_obj[i].middle_name + "</td><td>" + results_obj[i].dob + "</td></tr>";
		
	}
	
	//Place click event in with returned data
	results_output += "<script>$(document).ready(function(e) {$(\".patient_selector_tr\").click(function() {view_patient_record($(this).attr(\"patient_id\"));});});</script>";
	
	
	//Display results
	$("#patient_results_container").html(results_output);
	
}

function view_patient_record(id) {
	
	//Generate the patient record for the selected patient
	load_sub_content("process/ajax/load_patient_record?patient_id=" + id);
	
}