<!DOCTYPE html>
<html>
  <head>
    <title>Admin Login</title>
    <!-- Bootstrap -->
    <link href="<?php echo URLHelpers::frontend("bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet" media="screen">
    <link href="<?php echo URLHelpers::frontend("bootstrap/css/bootstrap-responsive.min.css"); ?>" rel="stylesheet" media="screen">
    <link href="<?php echo URLHelpers::frontend("assets/styles.css"); ?>" rel="stylesheet" media="screen">
    <link href="<?php echo URLHelpers::frontend("vendors/jGrowl/jquery.jgrowl.css"); ?>" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="<?php echo URLHelpers::frontend("vendors/modernizr-2.6.2-respond-1.1.0.min.js"); ?>"></script>
  </head>
  <body id="login">
    <div class="container">

<?php

if(Data::get_flash("login_attempt")) {

echo '<div class="alert alert-error alert-block"><h4 class="alert-heading">Login Failed.</h4>Please check you are using the correct login credentials and try again.</div>';
									
}
									
?>

      <form method="post" action="<?php echo URLHelpers::url("process/login"); ?>" class="form-signin">
        <h2 class="form-signin-heading">Login to continue.</h2>
        <input type="text" class="input-block-level" placeholder="Username" name="username">
        <input type="password" class="input-block-level" placeholder="Password" name="password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>