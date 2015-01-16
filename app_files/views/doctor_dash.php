<script>
$(".appointment_tr").click(function() {select_appointment($(this).attr("id"));});
$(".appointment_actions_item").click(function() {process_appointment_status_change($(this).attr("do"), "false");});
$(".appointment_actions_open").click(function() {get_patient_id();});

function get_patient_id() {
	
	load_sub_content("process/ajax/get_patient_id_from_appointment?appointment_id=" + current_selected_appointment.replace("appointment_", ""), "@open_patient_record");
	
}
function open_patient_record(patient_id) {
	
	load_content("process/ajax/load_patient_record?patient_id=" + patient_id, undefined, undefined, "#li_patient_records_search");
	
}
</script>
<div class="block">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Upcoming Appointments</div>
        <div class="btn-group pull-right" style="padding-top:0px;">
                 <button data-toggle="dropdown" class="btn dropdown-toggle" id="appointment_actions" style="display:none;">Action&nbsp;<span class="caret"></span></button>
                 <ul class="dropdown-menu">
                    <li class="appointment_actions_item" do="begin_patient"><a href="#"><strong>Send Patient In</strong></a></li>
                    <li class="appointment_actions_item" do="cancel_patient"><a href="#">Cancel Patient</a></li>
                    <li class="appointment_actions_open"><a href="#">Open Patient Record</a></li>
                 </ul>
              </div>
    </div>
    <div class="block-content collapse in">
        <div class="span12">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Time</th>
                  <th>Full Name</th>
                  <th>Appointment Type</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
<?php

//Display the appointments
foreach(Model::get("appointments")->get_upcoming_appointments() as $key => $value) {
	
	//Get correct class for the patient status
	$status = "";
	if($value["type"] == 1) {
		
		$status = "label label-success";
		
	} elseif($value["type"] == 2) {
		
		$status = "label label-info";
		
	} elseif($value["type"] == 3) {
		
		$status = "label label-warning";
		
	} elseif($value["type"] == 4) {
		
		$status = "label label-important";
		
	}
	
	echo "<tr class=\"appointment_tr\" id=\"appointment_" . $value["appointment_id"] . "\" href=\"#\"><td>" . date_format(date_create($value["start_stamp"]), "H:i") . " - " . date_format(date_create($value["end_stamp"]), "H:i") . "<br />" . date_format(date_create($value["start_stamp"]), "jS M") . "</td><td>" . strtoupper($value["title"]) . " " . $value["last_name"] . ", " . $value["first_name"] . " " . $value["middle_name"] . "</td><td>" . $value["name"] . "</td><td><span class=\"" . $status . "\">" . $value["status_name"] . "</span></td></tr>";
	
}
                
?>
              </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal hide" id="cancel_appointment_dialog">
  <div class="modal-header">
      <button data-dismiss="modal" class="close" type="button"></button>
      <h3>Cancel an appointment</h3>
  </div>
  <div class="modal-body">
      <p>Please give the reason for the cancellation, this <strong>will</strong> be visible to the patient<br /><br /><textarea id="cancel_patient_reason" style="width:98%;"></textarea></p>
  </div>
  <div class="modal-footer">
      <a data-dismiss="modal" class="btn btn-primary" href="#" id="cancel_appointment_bu">Cancel Appointment</a>
      <a data-dismiss="modal" class="btn" href="#">Close</a>
  </div>
</div>