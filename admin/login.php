<?php
	 session_start();

	if(isset($_SESSION["uid"])){
	  if((int)$_SESSION["groupID"] != 0){
	    header("Location: ../assets/php/classes/run.php?a=logout&p=admin");
	  }else{
	  	header("Location: /csci334/admin");
	  }
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Login</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

	<!-- Bootstrap 4 CSS -->
  	<link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.min.css"></link>
  	<link rel="stylesheet" type="text/css" href="../assets/css/login.css"></link>
</head>
<body>
	<div id="alert-div">
    
  	</div>
	<div class="login-div">
		<h1>Admin Login</h1>
		<input type="text" id="username" placeholder="Username/Email">
		<input type="password" id="password" placeholder="Password">
		<button id="login_btn">Login</button>
	</div>
	<!-- Jquery JS -->
	<script type="text/javascript" src="../assets/vendor/jquery/jquery.min.js"></script>
	<!-- Bootstrap JS -->
	<script type="text/javascript" src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../assets/js/sha256.js"></script>
	<script type="text/javascript">
		$(document).keydown((event)=>{
	      if(event.keyCode == 13){
	        $("#login-btn").click();
	      }
	    });
		$("#login_btn").click(()=>{
			if($("#username").val() == "" || $("#password").val() == ""){
		        createAlert("danger", "Username and password can't empty!");
		    }else{
		       $.ajax({
		            type: "POST",
		            dataType: "json",
		            url: "../assets/php/classes/run.php?a=login", 
		            data: {
		              username: $("#username").val(),
		              password: sha256($("#password").val()),
		              position: "staff"
		            },
		            success: function(data) {
		              console.log(data);
		              if(data[0] == false){
		                createAlert("danger", "Wrong username or password!");
		              }else{
		                location.href = "/csci334/admin";
		              }
		            }
		        });
		    }
		});

		function createAlert(type, content){
	      $("#alert-div").prepend('<div class="alert alert-'+type+' alert-dismissible fade show" role="alert">'+content+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
	    }
	</script>
</body>
</html>