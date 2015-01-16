//Current selected sidebar tab
var sidebar_tab_selected = "";

$(document).ready(function(e) {
    load_content("doctor_dash");
});

function show_loading() {
	
	$("#loading_gear").show();
	
}

function hide_loading() {
	
	$("#loading_gear").hide();
	
}

function load_content(url, place_content_in, post_data, override_tab) {
	
	//Check if the tab should be overriden or automatically selected
	var tab_to_select = "";
	if(typeof override_tab == 'undefined') {
		
		tab_to_select = "#li_" + url;
		
	} else {
		
		tab_to_select = override_tab;
		
	}
	
	//Make tab selected
	$(tab_to_select).addClass("active");
	
	//Check if there was a tab selected and if there was deselect it
	if(sidebar_tab_selected != "" && sidebar_tab_selected != tab_to_select) {
		
		$(sidebar_tab_selected).removeClass("active");
		
	}
	sidebar_tab_selected = tab_to_select;
	
	ajax_load(url, place_content_in, post_data);
	
}

function load_sub_content(url, place_content_in, post_data) {
	
	ajax_load(url, place_content_in, post_data);
	
}

function ajax_load(url, place_content_in, post_data) {
	
	place_content_in = typeof place_content_in !== 'undefined' ? place_content_in : "#content";
	post_data = typeof post_data !== 'undefined' ? post_data : "";
	
	show_loading();
	
	//Determine if this is a POST or GET request
	//POST requests will have "POST/" at the start of the url string
	var http_request = "GET";
	if(url.substring(0, 5) === "POST/") {
		
		http_request = "POST";
		url = url.slice(5);
		
	}
	
	//Start ajax request
	$.ajax({type: http_request, url: url, data: post_data }).done(function(data) {
		
		//Check if data should be rendered to the DOM or skipped
		if(place_content_in != "false" && place_content_in.charAt(0) != "@") {
			
			//Update page content
			$(place_content_in).html(data);
		
		} if(place_content_in.charAt(0) == "@") {
			
			//Call user function to continue
			window[place_content_in.substr(1)](data);
		
		}
		
		//Remove loading gear
		hide_loading();
		
	});
	
}