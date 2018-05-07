<?php
	include("../methods.php");
	$confFile = "../settings.conf.php";
	include($confFile);
	if (!setupCheck($confFile)) header('Location: ../install/index.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	
    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<link href="signin.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form id="form-signin" class="form-signin">
      <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Username</label>
      <input name="uname" type="text" id="inputEmail" class="form-control" placeholder="Username" required autofocus></br>
      <label for="inputPassword" class="sr-only">Password</label>
      <input name="pword" type="password" id="inputPassword" class="form-control" placeholder="Password" required></br>
      <!--<div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>-->
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
	  <a href="../index.php" style="display:none;"  id="redirect"></a>
      <!--<button class="btn btn-lg btn-primary btn-block" type="submit">Signup</button>-->
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<script src="../simulate/jquery.simulate.js"></script>
	<script>
		$(document).ready(function() {
			 $("#form-signin").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type : "POST",
                    url : "loginCheck.php",
                    data : $("#form-signin").serialize(),
                    beforeSend : function() {
                          //$(".post_submitting").show().html("<center><img src='images/loading.gif'/></center>");
                    },
                    success : function(response) {
                        if (response != "false") {
							$("#redirect").simulate('click');
						}
						else {
							alert("Invalid Login");
						}
                    }
                });
            });
		});
	</script>
  </body>
</html>
