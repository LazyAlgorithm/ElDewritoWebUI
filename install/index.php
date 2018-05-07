<?php
	include("../methods.php");
	$confFile = "../settings.conf.php";
	include($confFile);
	if (setupCheck($confFile)) {
		header('Location: ../index.php');
	}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!--<link rel="icon" href="../../../../favicon.ico">-->

    <title>Install UI</title>

    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-setup" novalidate>
      <h1 class="h1 mb-3 font-weight-normal">Setup</h1>
	  <div id="formContainer">
      <h1 class="h3 mb-3 font-weight-normal">Config File</h1><hr/>
      <label for="congLocation">Path to dewrito_prefs.cfg</label>
      <input type="text" name="congLocation" id="congLocation" class="form-control" placeholder="c:\haloonline\dewrito_prefs.cfg" required autofocus>
	  <br/>
	   <h1 class="h3 mb-3 font-weight-normal">Default User</h1><hr/>
	  <label for="uname">Username</label>
      <input name="uname" type="text" id="inputEmail" class="form-control" placeholder="Username" required><br/>
	  <div id="passrow" class="row">
		<div class="col-xs-6 col-sm-6 col-md-6">
			<div class="form-group">
				<label for="pword">Password</label>
				<input type="password" name="pword" id="pword" class="form-control input-sm" placeholder="Password" required>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6">
			<div class="form-group">
				<label for="pword2">Password</label>
				<input type="password" name="pword2" id="pword2" class="form-control input-sm" placeholder="Confirm Password">
			</div>
		</div>
	</div>
	
	 <h1 class="h3 mb-3 font-weight-normal">Database Info</h1><hr/>
	  <div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6">
			<div class="form-group">
				<label for="sqlhost">SQL Host (if you don't know, keep it localhost)</label>
				<input type="text" name="sqlhost" id="sqlhost" class="form-control input-sm" placeholder="SQL Host" value="localhost" required>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6">
			<div class="form-group">
				<label for="sqldb">Database Name</label>
				<input type="text" name="sqldb" id="sqldb" class="form-control input-sm" placeholder="Database Name" required>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6">
			<div class="form-group">
				<label for="sqluname">SQL Username</label>
				<input type="text" name="sqluname" id="sqluname" class="form-control input-sm" placeholder="SQL Username" required>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6">
			<div class="form-group">
				<label for="sqlpword">Database User Password</label>
				<input type="password" name="sqlpword" id="sqlpword" class="form-control input-sm" placeholder="Database User Password" required>
			</div>
		</div>
	</div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Complete</button>
	  <a href="../index.php" style="display:none;"  id="redirect"></a>
	  </div>
    </form>
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	
    <!-- Icons -->
	<script src="../slider.js"></script>
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
	<script src="../simulate/jquery.simulate.js"></script>
	<script>
		feather.replace();
		var validationAttempt = 1;
		function checkForm() {
			validationAttempt = 1;
			var allInputs = $( ":input" );
			$('.form-setup input').each(function(){
				$(this).removeClass("invalid");
				$(this).removeClass("valid");
				if($(this).val() == '') {
					$(this).addClass("invalid");
					validationAttempt = 0;
				}
				else
					$(this).addClass("valid");
			});
			if (!validationAttempt) {
				alert("Please fill out the required information");
				if ($("#pword").val() != $("#pword2").val()) {
					alert("Passwords must match");
					$("#pword2").removeClass("valid");
					$("#pword2").addClass("invalid");
				}
				return validationAttempt;
			}
			if ($("#pword").val() != $("#pword2").val()) {
				$("#pword2").removeClass("valid");
				$("#pword2").addClass("invalid");
				
				$("#pword").removeClass("invalid");
				$("#pword").addClass("valid");
				
				alert("Passwords must match");
				$("#pword2").focus();
				$("#pword2").select();
				validationAttempt = 0;
				return validationAttempt;
			}
			return validationAttempt;
		}
		$(document).ready(function() {
			$(".form-setup").submit(function(e) {
                e.preventDefault();
				if (!checkForm()) {
					return;
				}
                $.ajax({
                    type : "POST",
                    url : "install.php",
                    data : $(".form-setup").serialize(),
                    beforeSend : function() {
                          //$(".post_submitting").show().html("<center><img src='images/loading.gif'/></center>");
                    },
                    success : function(response) {
						alert(response);
                        if (response == "success") {
							alert("Setup Complete");
							$("#redirect").simulate('click');
						}
						else if (response == "exists") {
							alert("Setup not needed");
							$("#redirect").simulate('click');
						}
						else
							alert("There was a problem with the setup");
                    },
					error: function (request, status, error) {
						alert("There was a problem with the setup");
					}
                });
            });
			
		});
	</script>
  </body>
</html>
