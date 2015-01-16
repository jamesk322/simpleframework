<script>
$("#patient_advanced_search").click(function() {show_advanced_search();});
$("#patient_search_lastname").on("input propertychange paste", function() {process_patient_search();});
$(".datepicker").datepicker({format: "dd/mm/yyyy"});
</script>

<h2>Search patient records</h2>
Search for a patient using their last name, or in advanced settings you can search by Patient ID, appointments or patient registration dates and other information.
<br />
<h4>Basic search</h4>
<input type="text" placeholder="Patient's last name" id="patient_search_lastname" style="width:300px;" />
<br />
<div style="text-align:right;" id="patient_advanced_search"><a href="#">Advanced Search</a></span></div>

<div style="display:none" id="advanced_search_terms">

<h4>Advanced search</h4>

<div style="width:150px; display:inline-block;">Date of Birth</div><div style="display:inline-block;"><input type="text" class="datepicker" id="dob" value="" style="width:100px; margin-top:5px;" data-date-viewMode="years"></div>

<br />

<div style="width:150px; display:inline-block;">Patient ID</div><div style="display:inline-block;"><input type="text" placeholder="#PID" id="pid" style="width:50px; margin-top:5px;" /></div>

<br />

<div style="width:150px; display:inline-block;">Appointment Date</div><div style="display:inline-block;"><input type="text" class="datepicker" id="appointment_date" value="" style="width:100px; margin-top:5px;"></div>

<br />

<div style="width:150px; display:inline-block;">Registration Date</div><div style="display:inline-block;"><input type="text" class="datepicker" id="registration_date" value="" style="width:100px; margin-top:5px;"></div>

</div>

<div class="block">
<div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Patient Results</div>
</div>
<div class="block-content collapse in">
    <div class="span12">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>PID</th>
              <th>Name</th>
              <th>D.O.B</th>
            </tr>
          </thead>
          <tbody id="patient_results_container" style="font-weight:100;">
            
          </tbody>
        </table>
    </div>
</div>
</div>
