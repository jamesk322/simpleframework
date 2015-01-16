<?php

$patient_data = Model::get("patient")->find(array("patient_id" => $args["patient_id"]))[0];
$medical_notes = Model::get("patient")->get_medical_notes(array("patient_id" => $args["patient_id"]));

?>
<h2><?php echo $patient_data["title"] . " " . $patient_data["last_name"] . ", " . $patient_data["first_name"] . " " . $patient_data["middle_name"]; ?></h2>
<br />
<div class="row-fluid">
<!-- block -->
<div class="block">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Personal Details</div>
    </div>
    <div class="block-content collapse in">
        <div class="span12">
            
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width:25%; font-weight:normal;">Last Name: <a href="#"><?php echo $patient_data["last_name"]; ?></a></th>
                  <th style="width:25%; font-weight:normal;">First Name(s): <?php echo $patient_data["first_name"] . " " . $patient_data["middle_name"]; ?></th>
                  <th style="width:25%; font-weight:normal;">Title: <?php echo $patient_data["title"]; ?></th>
                  <th style="width:25%; font-weight:normal;">Patient ID: <?php echo $patient_data["patient_id"]; ?></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>DOB: <?php echo $patient_data["dob"]; ?></td>
                  <td>Primary Phone: <?php echo $patient_data["phone_primary"]; ?></td>
                  <td>Secondary Phone: <?php echo $patient_data["phone_secondary"]; ?></td>
                  <td>Address: <?php echo $patient_data["address"]; ?></td>
                </tr>
              </tbody>
            </table>
            
        </div>
    </div>
</div>


<div class="block">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Medical Notes&nbsp;&nbsp;&nbsp;<span class="badge badge-info"><?php echo $medical_notes["num_rows"]; ?></span></div>
        <div class="pull-right" style="padding-top:0px;"><button class="btn btn-primary" id="create_new_note"><i class="icon-plus icon-white"></i> New</button></div>
    </div>
    <div class="block-content collapse in">
        <div class="span12">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th style="overflow:hidden; white-space:nowrap;">Date Created</th>
                  <th>Summary</th>
                  <th style="overflow:hidden; white-space:nowrap;">Created By</th>
                </tr>
              </thead>
              <tbody><?php
			  
//Display all medical notes for this patient
foreach($medical_notes["results"] as $key => $value) {
	
	echo "<tr><td style=\"overflow:hidden; white-space:nowrap;\">" . date_format(date_create($value["stamp_created"]), "d/m/Y") . "</td><td>" . $value["data_summary"] . "</td><td style=\"overflow:hidden; white-space:nowrap;\">" . $value["display_name"] . "</td></tr>";
	
}

              ?></tbody>
            </table>
        </div>
    </div>
</div>
<!-- /block -->
</div>
<script>
$(document).ready(function(e) {
    $("#create_new_note").click(function() {$(this).attr("disabled", true); load_sub_content("process/ajax/patient_new_note?patient_id=<?php echo $args["patient_id"]; ?>");});
});
</script>