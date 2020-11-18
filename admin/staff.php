<?php
	 session_start();

	if(isset($_SESSION["uid"])){
	  if((int)$_SESSION["groupID"] != 0){
	    header("Location: ../assets/php/classes/run.php?a=logout&p=admin");
	  }else{
	  	require_once "../assets/php/classes/build.php";
		  $userFac = new userFactory();
		  $userObj = $userFac->getUser($_SESSION["groupID"], $_SESSION["uid"]);
	  }
	}else{
		header("Location: /csci334/admin/login.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Staffs List: Adtech IT Consultation</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

	<!-- Bootstrap 4 CSS -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  	<link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.min.css"></link>
  	<link rel="stylesheet" type="text/css" href="../assets/css/root.css"></link>
  	<link rel="stylesheet" type="text/css" href="../assets/css/customer.css"></link>
  	<link rel="stylesheet" type="text/css" href="../assets/css/staff.css"></link>
</head>
<body>
	<?php
		if($userObj->getPermissionID() == 2 || $userObj->getPermissionID() == 1){
			echo '<div class="modal fade" id="addStaff" tabindex="-1" role="dialog" aria-labelledby="addStaff" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addStaffTitle">Add New Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row no-gutters"><span class="col-2">Staff ID:</span>
            	<input id="sid" class="col-4 form-control" type="text" placeholder="Enter Staff ID"><span class="col-2 pl-2">Position</span>
            		<select class="col-4 form-control" id="position">';
            	if($userObj->getPermissionID() == 1){
            		echo '<option value="3">IT Technician</option><option value="2">Manager</option>';
            	}else if($userObj->getPermissionID() == 2){
            		echo '<option value="3">IT Technician</option>';
            	}
            	
            	echo '</select><span class="col-2">First Name:</span>
            	<input id="fname" class="col-4 form-control" type="text" placeholder="Enter First Name">
            	<span class="col-2 pl-2">Last Name:</span>
            	<input id="lname" class="col-4 form-control" type="text" placeholder="Enter Last Name">
            	<span class="col-2">Contact:</span>
            	<input id="contact" class="col-10 form-control" type="text" placeholder="Enter Contact">
            	<span class="col-2">Email:</span>
            	<input id="email" class="col-10 form-control" type="text" placeholder="Enter Email">
            	<span class="col-2">Password:</span>
            	<input id="pass" class="col-10 form-control" type="password" placeholder="Enter Password">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-main" id="addStaffBtn">Save</button>
          </div>
        </div>
      </div>
  </div>';
		}
	?>
	<!-- Loading Page -->
	<div class="loading-wrapper">
		<div class="loading-title">
			<span>Loading</span>
		</div>
		<div class="loading-dots">
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
		</div>
	</div>

	<!-- Body -->
	<div class="w-100 body row no-gutters">
		<!-- Sidebar -->
		<nav id="sidebar" class="col-2">
			<ul class="list-unstyled components">
				<?php 
					foreach (ADTECH::getMenu() as $menu) {
						if($menu->userAuth($userObj->getPermissionID()) == true){
							if(sizeof($menu->print()["subMenu"]) > 0){
								echo '<li class="" href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><a>'.$menu->print()["label"].'</a><ul class="collapse list-unstyled" id="homeSubmenu">';
								foreach ($menu->getSubMenus() as $subMenu) {
									if($subMenu->userAuth($userObj->getPermissionID()) == true){
										echo '<li><a href="'.$subMenu->print()["path"].'">'.$subMenu->print()["label"].'</a></li>';
									}
								}
								echo '</ul>';

							}else{
								echo '<li><a href="'.$menu->print()["path"].'">'.$menu->print()["label"].'</a></li>';
							}
						}
					}
				?>
			</ul>
		</nav>
		<!-- Page Content -->
		<div class="col-10">

			<!-- Header -->
			<header id="header" class="d-flex justify-content-between">
				<div class="text-left">
					<span>AdTech IT Consulting</span>
				</div>

				<div>
					<div class="noti_div">
						<button type="button" class="notification-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-bell"></i></button>
						<span class="noti-num">1</span>
					  <div class="notifications dropdown-menu dropdown-menu-right">

					  </div>
					</div>

					<div class="btn-group">
	  					<button type="button" class="btn btn-grey dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    <?php echo $userObj->getData()["fname"] . " " . $userObj->getData()["lname"] ." (". $userObj->getData()["position"] . ")"?>
					  </button>
					  <div class="dropdown-menu dropdown-menu-right">
					    <a class="dropdown-item logout" href="../assets/php/classes/run.php?a=logout&p=admin">Logout</a>
					  </div>
					</div>
				</div>
			</header>

			<!-- Content -->
			<div class="align-items-stretch content">
				<!-- Main Content -->
				<main class="p-4">
					<div class="d-flex justify-content-between align-items-start">
						<h1 class="page-title">Staffs Management</h1>
						<?php
							if($userObj->getPermissionID() == 2 || $userObj->getPermissionID() == 1){
								echo '<button class="btn btn-main" id="addStaff" type="button" data-toggle="modal" data-target="#addStaff">Add Staff</button>';
							}
						?>
						
					</div>
					
					<div class="tablelist">
			          <table class="table table-sm table-hover" id="record_table">
			       		<?php
			       			$staffList = new getStaffDetails(ADTECH::getDB());
			       			$staffs = $staffList->execute();
			       			if(sizeof($staffs) >= 1){
		       				
								if($userObj->getPermissionID() == 2){
			       					echo '<thead><tr><th scope="col">Staff#</th><th scope="col">First Name</th><th scope="col">Last Name</th><th scope="col">Contact</th><th scope="col">Email</th><th scope="col">Assigned/On-Going/Completed</th><th scope="col">Completion Rate</th><th scope="col">Overtime hour</th><th scope="col">Overtime Pay</th></tr></thead><tbody>';
			       				}

			       				foreach ($staffs as $staff) {
			       					if($staff["assigned"] != 0){
			       						$progress = $staff["assigned"]."/".$staff["ongoing"]."/".$staff["completed"];
			       						$comRate = number_format($staff["completed"]/$staff["assigned"]*100, 2, '.', '') . "%";
			       						if($staff["completed"]/$staff["assigned"]*100 < 40){
				       						$comRate .= "<img title='Low Performance Alert' style='height: 25px;padding-left: 5px;vertical-align: bottom;' src=\"https://static.ariste.info/wp-content/uploads/2020/04/1200px-Antu_dialog-warning.svg_-1.png\">";
				       					}
			       					}else{
			       						$progress = "0/0/0";
			       						$comRate = number_format(0, 2, '.', '') . "%";
			       					}
			       					
			       					
				       				echo '<tr><td>'.$staff["sid"].'</td><td>'.$staff["fname"].'</td><td>'.$staff["lname"].'</td><td>'.$staff["contact"].'</td><td>'.$staff["email"].'</td><td>'.$progress.'</td><td>'.$comRate.'</td><td>'.$staff["overtimehr"].'</td><td>RM '.number_format(($staff["overtime"]*0.0055556), 2, '.', '').'</td></tr>';
				       			}

				       			echo '</tbody></table>';
			       			}
			       			
			       		?>    
			          </table>
				     </div>
				</main>
				<!-- Footer -->
				<footer id="footer"></footer>
			</div>

			
		</div>

		
	</div>

	<!-- Jquery JS -->
	<script type="text/javascript" src="../assets/vendor/jquery/jquery.min.js"></script>
	<!-- Bootstrap JS -->
	<script type="text/javascript" src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Google Chart API JS -->
  	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  	<script type="text/javascript" src="../assets/js/sha256.js"></script>
	<script type="text/javascript">
		$("#footer").load("../assets/snippet/footer.html");
		var position = <?php echo $userObj->getPermissionID() ?>;
		var uid = <?php echo '"'. $userObj->getData()["id"] .'"' ?>;

		//connect to socket
		var sock = new WebSocket("ws://localhost:55000");
		var userList = [];
		sock.onopen = function(event){
			sock.send('{"action":"open", "uid":"'+ uid +'"}');	
		};

		sock.onmessage = function(event){
			const jsonData = JSON.parse(event.data);
			if(jsonData.action == "notifyAll" || jsonData.action == "notify"){
				console.log(jsonData);
				if(jsonData.msg == "notification"){
					getNotification();
				}
			}else if(jsonData.action == "list"){
				const clients = (jsonData.msg).split(",");
				clients.forEach((key)=>{
					userList.push(key);
				});
			}
			
		};

		sock.onerror = function(error){
			console.log("Can't connect to server");
		}

		$(window).on("unload", function(e) {
		    sock.close(1000,'{"uid":"'+ uid +'"}');
		});

		function getNotification(){
			$.ajax({
	          type: "POST",
	          dataType: "json",
	          url: "../assets/php/classes/run.php?a=getNotification",
	          data:{
	          	uid: uid,
	          	pos: position
	          },
	          success: function(data) {
	          	if(data[0] == true){
	          		if(data[2] == "0"){
		          		$(".noti-num")[0].style.display = "none";
		          	}else{
		          		$(".noti-num")[0].style.display = "";
		          		$(".noti-num")[0].innerHTML = data[2];
		          	}
		          	$(".notifications")[0].innerHTML = "";
		            data[1].forEach((noti)=>{
		            	if(noti["read"] == 1){
		            		$(".notifications").append('<div class="notification no-gutters" data-nid=""><div class="col-11"><span class="noti-title read">'+noti["title"]+'</span><span class="noti-content read">'+noti["content"]+'</span><span class="noti-date">'+noti["date"]+'</span></div><div class="col-1"></div></div>');
		            	}else{
		            		$(".notifications").append('<div class="notification no-gutters" data-nid="'+noti["nid"]+'"><span class="noti-title"><b>'+noti["title"]+'</b></span><span class="noti-content"><b>'+noti["content"]+'</b></span><span class="noti-date">'+noti["date"]+'</span></div>');
		            	}
		            	
		            });
	          	}else{
	          		$(".noti-num")[0].style.display = "none";
	          	}

	            $(".notification").click((event)=>{
					if(event.currentTarget.getAttribute("data-nid") != ""){
						$.ajax({
				          type: "POST",
				          dataType: "json",
				          url: "../assets/php/classes/run.php?a=readNoti", 
				          data:{
				          	nid: event.currentTarget.getAttribute("data-nid")
				          },
				          success: function(data) {
				            console.log(data);
				            getNotification();
				          }
				      	});
					}
						
				});
	          }
	      	});
		}

		$(document).ready(()=>{
			getNotification();
			$('.loading-wrapper').addClass('hide');
			if(position == 2 || position == 1){
				$("#addStaffBtn").click(()=>{
					$.ajax({
		              type: "POST",
		              dataType: "json",
		              url: "../assets/php/classes/run.php?a=addStaff", 
		              data: {
		                rid: $("#sid").val(),
						fname: $("#fname").val(),
						lname: $("#lname").val(),
						contact: $("#contact").val(),
						email: $("#email").val(),
						pass: sha256($("#pass").val()),
						pos: $("#position").val()
		              },
		              success: function(data) {
		                if(data[0] == true){
		                	location.reload();
		                }
		              }
		          });
				});
			}
		});
	</script>
</body>
</html>