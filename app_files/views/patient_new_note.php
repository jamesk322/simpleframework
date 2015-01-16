<?php

//Get patient data
$patient_data = Model::get("patient")->find(array("patient_id" => $args["patient_id"]))[0];

?>
<div style="position:relative; height:50px;"><div style="position:absolute; left:0px; top:0px; margin-top:0px;"><h2>New Medical Note</h2></div><div style="position:absolute; right:0px; top:0px; margin-top:0px;"><button class="btn btn-primary" id="save_note"><i class="icon-ok icon-white"></i> Save</button>&nbsp;<button class="btn tooltip-top" id="set_autosave"><i class="icon-refresh"></i> Autosave (on)</button></div></div>
<h4><i>for</i>&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $patient_data["title"] . " " . $patient_data["last_name"] . ", " . $patient_data["first_name"] . " " . $patient_data["middle_name"]; ?></h4>
<br />

<textarea id="patient_note"></textarea>

<br />

<div class="block">
<div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Note Summary</div>
</div>
<div class="block-content collapse in">
    <div class="span12">
    	The summary should briefly describe the contents of this medical note, this will be visible in search results.<br /><i>Automatic generation will use the first 300 characters of the medical note.</i><br /><br />
    	<textarea id="patient_note_summary" disabled style="width:98%;"></textarea><br />
        <label><input type="radio" name="auto_summary" id="auto_summary_true" value="true" checked>&nbsp;&nbsp;Automatically generate summary for this medical note</label>
        <label><input type="radio" name="auto_summary" id="auto_summary_false" value="false">&nbsp;&nbsp;Manually enter summary</label>
    </div>
</div>
</div>

<div class="row-fluid">
<div class="span6">
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Upload New File</div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">
                <input type="file" name="file_upload" id="file_upload" />
            </div>
        </div>
    </div>
    <!-- /block -->
</div>
<div class="span6">
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Files</div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">

                
            </div>
        </div>
    </div>
    <!-- /block -->
</div>
</div>
<script>

var auto_summary_status = true;

function handle_note_data_change(inst) {
	
	if(auto_summary_status === true) {
		
		var summary_text = $("<div/>").html(tinymce.get("patient_note").getContent().substring(0, 300)).text();
		$("#patient_note_summary").val(summary_text);
		
	}
	
}

$(document).ready(function(e) {
	
	tinymce.init(
	{
		selector: '#patient_note',
		setup: function(editor) {
			
			editor.on("change", handle_note_data_change);
			editor.on("keyup", handle_note_data_change);
			editor.on("init", function(e) { window.scrollTo(0, 0); });
			
		}
	});
	
	$(".tooltip-top").tooltip({
		
		title: "",
		trigger: "manual"
		
	});
	
	$('#file_upload').uploadify({
        'swf'      : '<?php echo URLHelpers::frontend("uploadify/uploadify.swf"); ?>',
        'uploader' : '<?php echo URLHelpers::frontend("uploadify/uploadify.php"); ?>',
		'buttonClass' : 'btn btn-primary'
    });
	
	autosave_note();
	
});

$("#save_note").click(function() {
	
	$(this).attr("disabled", true);
	
	load_sub_content("POST/process/ajax/update_note?db_insert_id=<?php echo $args["db_insert_id"]; ?>", undefined, {
		
		note_data: tinymce.get("patient_note").getContent(),
		patient_note_summary: $("#patient_note_summary").val()
		
		});
	
});

$("#set_autosave").click(function(e) {
	
	if($(this).html() == "<i class=\"icon-refresh\"></i> Autosave (on)") {
		
		$(this).html("<i class=\"icon-refresh\"></i> Autosave (off)");
		
	} else {
		
		$(this).html("<i class=\"icon-refresh\"></i> Autosave (on)");
		
	}
	
	$(this).blur();
	
});

$("#set_autosave").hover(function() {
	
	//Check if the autosave function is turned on and load up the correct tooltip
	if($("#set_autosave").html() == "<i class=\"icon-refresh\"></i> Autosave (on)") {
		
		load_sub_content("process/ajax/get_last_autosave_stamp?db_insert_id=<?php echo $args["db_insert_id"]; ?>", "@load_last_autosave_data");
		
	} else {
		
		$('.tooltip-top').attr('data-original-title', "Autosave is turned off, click to turn on").tooltip("fixTitle").tooltip("show");
		
	}
	
}, function() {
	
	$(".tooltip-top").tooltip("hide");
	
});

$("#auto_summary_true, #auto_summary_false").change(function() {
	
	//Check if the user has requested the auto summary feature on or off
	if($(this).val() === "true") {
		
		auto_summary_status = true;
		$("#patient_note_summary").prop("disabled", true);
		
	} if($(this).val() === "false") {
		
		auto_summary_status = false;
		$("#patient_note_summary").prop("disabled", false);
		
	}
	
});

function load_last_autosave_data(data) {
	
	var tooltip_text = "";
	if(data != "false") {
		
		tooltip_text = "last autosave: " + data;
		
	} else {
		
		tooltip_text = "There haven't been any autosaves yet";
		
	}
	
	$('.tooltip-top').attr('data-original-title', tooltip_text).tooltip("fixTitle").tooltip("show");
	
}

function autosave_note() {
	
	//Autosave the note every 2 mins
	setInterval(function() {
		
		if($("#set_autosave").html() == "<i class=\"icon-refresh\"></i> Autosave (on)") {
			
			//Process the autosave through ajax
			load_sub_content("POST/process/ajax/autosave_note", "false", {
				
				db_insert_id: <?php echo $args["db_insert_id"]; ?>,
				data_autosave: tinymce.get("patient_note").getContent()
				
			});
			
		}
		
	}, 120000);
	
}

</script>