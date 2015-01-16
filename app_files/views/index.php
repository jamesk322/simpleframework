<?php

//Collect view vars
$user = Model::get("user");
$pages = Model::get("pages");
$args = array();
array_push($args, $user->get_user());
array_push($args, $pages->generate_side_navigation_array());

?>
<!DOCTYPE html>
<html class="no-js">
    
    <head>
        <title>Admin Home Page</title>
        <!-- Bootstrap -->
        <link href="<?php echo URLHelpers::frontend("bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet" media="screen">
        <link href="<?php echo URLHelpers::frontend("bootstrap/css/bootstrap-responsive.min.css"); ?>" rel="stylesheet" media="screen">
        <link href="<?php echo URLHelpers::frontend("vendors/easypiechart/jquery.easy-pie-chart.css"); ?>" rel="stylesheet" media="screen">
        <link href="<?php echo URLHelpers::frontend("assets/styles.css"); ?>" rel="stylesheet" media="screen">
        <link href="<?php echo URLHelpers::frontend("assets/portamento.css"); ?>" rel="stylesheet" media="screen">
        <link rel="stylesheet" type="text/css" href="<?php echo URLHelpers::frontend("uploadify/uploadify.css"); ?>" />
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="<?php echo URLHelpers::frontend("vendors/modernizr-2.6.2-respond-1.1.0.min.js"); ?>"></script>
    </head>
    
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Practice CP</a>
                    <div class="nav-collapse collapse"><span id="loading_gear" style="display:none;"><img src="<?php echo URLHelpers::frontend("images/gear.gif"); ?>" style="padding-top:4px;" /></span>
                        <ul class="nav pull-right">
                        
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> <?php echo $args[0]["display_name"]; ?> <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">Profile</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a tabindex="-1" href="login.html">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav">
                            <li class="active">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Settings <b class="caret"></b>

                                </a>
                                <ul class="dropdown-menu" id="menu1">
                                    <li>
                                        <a href="#">Tools <i class="icon-arrow-right"></i>

                                        </a>
                                        <ul class="dropdown-menu sub-menu">
                                            <li>
                                                <a href="#">Reports</a>
                                            </li>
                                            <li>
                                                <a href="#">Logs</a>
                                            </li>
                                            <li>
                                                <a href="#">Errors</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">SEO Settings</a>
                                    </li>
                                    <li>
                                        <a href="#">Other Link</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#">Other Link</a>
                                    </li>
                                    <li>
                                        <a href="#">Other Link</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Content <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">Blog</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">News</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Custom Pages</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Calendar</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a tabindex="-1" href="#">FAQ</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Users <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">User List</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Search</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Permissions</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
            <div id="psidebar">
                <div class="span3" id="sidebar" style="width:300px;">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
<?php
                        
//Sidebar
$nav_build = "";
foreach($args[1] as $key => $value) {
			
	$nav_build .= "<li id=\"li_" . $value . "\"><a href=\"#\"><i class=\"icon-chevron-right\"></i> " . $key . "</a></li>";
			
}
echo $nav_build;
						
?>
                    </ul>
                </div>
                </div>
                
                <!--/span-->
				<div class="span9" style="margin-left:0px;">
				<?php
					
					//Check if user has just logged in and display message
					if($user->detect_just_logged_in()) {
						
						echo "<div class=\"alert alert-info alert-block\">
										<a class=\"close\" data-dismiss=\"alert\" href=\"#\">x</a>
										<h4 class=\"alert-heading\">Welcome back,</h4>
										There have been <strong>" . $args[0]["failed_login_attempts"] . "</strong> failed login attempts since your last login.
									</div>";
						
					}
					
					?>
                    </div>
                <div class="span9" id="content">
                    
                </div>
            </div>
            <hr>
            <footer>
                <p>&nbsp;</p>
            </footer>
        </div>
        <!--/.fluid-container-->
        <link href="<?php echo URLHelpers::frontend("vendors/datepicker.css"); ?>" rel="stylesheet" media="screen">
        <script src="<?php echo URLHelpers::frontend("vendors/jquery-1.9.1.min.js"); ?>"></script>
        <script src="<?php echo URLHelpers::frontend("bootstrap/js/bootstrap.min.js"); ?>"></script>
        <script src="<?php echo URLHelpers::frontend("vendors/easypiechart/jquery.easy-pie-chart.js"); ?>"></script>
        <script src="<?php echo URLHelpers::frontend("assets/scripts.js"); ?>"></script>
        <script src="<?php echo URLHelpers::frontend("js/site_js.js"); ?>"></script>
        <script src="<?php echo URLHelpers::frontend("js/appointments.js"); ?>"></script>
        <script src="<?php echo URLHelpers::frontend("js/patient.js"); ?>"></script>
        <script src="<?php echo URLHelpers::frontend("js/portamento-min.js"); ?>"></script>
        <script src="<?php echo URLHelpers::frontend("vendors/bootstrap-datepicker.js"); ?>"></script>
        <script src="<?php echo URLHelpers::frontend("vendors/tinymce/js/tinymce/tinymce.min.js"); ?>"></script>
        <script src="<?php echo URLHelpers::frontend("uploadify/jquery.uploadify.min.js"); ?>"></script>
        <script>
        $(function() {
            
        });
		$(document).ready(function(e) {
            $('#psidebar').portamento({gap: 30});
        });
		
<?php

//Inline JS
$js_build = "";
foreach($args[1] as $key => $value) {
			
	$js_build .= "$( \"#li_" . $value . "\" ).click(function(){load_content(\"" . $value . "\");});" ;
			
}
echo $js_build;
		
?>

refresh_appointments();
        </script>
    </body>

</html>