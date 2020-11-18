<?php
	 session_start();

	if(isset($_SESSION["uid"])){
	  if((int)$_SESSION["groupID"] != 0){
	    header("Location: ../assets/php/classes/run.php?a=logout&p=admin");
	  }else{
	  	require_once "../assets/php/classes/build.php";
		  $userFac = new userFactory();
		  $userObj = $userFac->getUser($_SESSION["groupID"], $_SESSION["uid"]);

		  $getSummary = new getSummary(ADTECH::getDB());
	  }
	}else{
		header("Location: /csci334/admin/login.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard: Adtech IT Consultation</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

	<!-- Bootstrap 4 CSS -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  	<link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.min.css"></link>
  	<link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css"></link>
</head>
<body>
	<?php
		if($userObj->getPermissionID() == 2){
			echo '<div class="modal fade" id="reassignDiv" tabindex="-1" role="dialog" aria-labelledby="reassignDiv" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="reassignDivTitle">Reassign Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="d-flex justify-content-between align-items-center">
            	<span class="mr-3">Staff:</span>
            	<select id="staff_sel" class="form-control">
            		<option value="0">Select a staff</option>
            	</select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-main" id="reassignCom">Reassign</button>
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
						<span class="noti-num"></span>
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
				<main class="row no-gutters p-4">
					<h1 class="page-title col-12"><?php echo $userObj->getData()["position"] . " Dashboard" ?></h1>
					<div class="dashboard col-12">
						<div class="home-container">
							<div class="row summary">
								<div class="col-12">
									<h5>Request Summary</h5>
								</div>
							</div>
							<table class="summary">
								<tr>
									<th>New Requests:</th>
									<td>
											<?php
												$sum_param = array("new");
												$getSummary->setParam($sum_param);
												$sum_result = $getSummary->execute();
												if(sizeof($sum_result) == 1){
													if($sum_result[0]["count"] > 1){
														echo '<span>'.$sum_result[0]["count"].' requests</span>';
													}else{
														echo '<span>'.$sum_result[0]["count"].' request</span>';
													}
												}
											?>
									</td>
								</tr>
								<tr>
									<th>On-Going Requests:</th>
									<td>
											<?php
												$sum_param = array("ongoing");
												$getSummary->setParam($sum_param);
												$sum_result = $getSummary->execute();
												if(sizeof($sum_result) == 1){
													if($sum_result[0]["count"] > 1){
														echo '<span>'.$sum_result[0]["count"].' requests</span>';
													}else{
														echo '<span>'.$sum_result[0]["count"].' request</span>';
													}
												}
											?>
									</td>
								</tr>
								<tr>
									<th>Completed Requests:</th>
									<td>
											<?php
												$sum_param = array("completed");
												$getSummary->setParam($sum_param);
												$sum_result = $getSummary->execute();
												if(sizeof($sum_result) == 1){
													if($sum_result[0]["count"] > 1){
														echo '<span>'.$sum_result[0]["count"].' requests</span>';
													}else{
														echo '<span>'.$sum_result[0]["count"].' request</span>';
													}
												}
											?>
									</td>
								</tr>
								<tr>
									<th>Average Time to Close Request:</th>
									<td>
											<?php
												$sum_param = array("avgTime");
												$getSummary->setParam($sum_param);
												$sum_result = $getSummary->execute();
												if(sizeof($sum_result) == 1){
													echo '<span>'.$sum_result[0]["count"].'</span>';
												}
											?>
									</td>
								</tr>
							</table>
						</div>
						<div class="home-container">
							<div class="row">
								<div class="col-12">
									<h5>Overtime Working Hours of IT Technician</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<div id="column-chart"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 text-right">
									<a type="button" class="btn btn-main" href="staff.php">View Details >></a>
								</div>
							</div>
						</div>
						<div class="home-container">
							<div class="row">
								<div class="col-12">
									<h5>Overall Request Rating by Client</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<dir id="pie-chart"></dir>
								</div>
							</div>
							<?php
								if($userObj->getPermissionID() == 1){
									echo '<div class="row">
								<div class="col-12 text-right">
									<a type="button" class="btn btn-main" href="customerReview.php">View Details >></a>
								</div>
							</div>';
								}
							?>
						</div>
						<?php
							if($userObj->getPermissionID() == 2){
								echo '<div class="home-container">
							<div class="row">
								<div class="col-12">
									<h5>Overtime Due Request</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<div class="table-responsive">
										<table id="table-request" class="table">';

								date_default_timezone_set("Asia/Kuala_Lumpur");
								$filterReq = new filterRequest(ADTECH::getDB());
								
								$param = array("overdue");
								$filterReq->setParam($param);
								$result = $filterReq->execute();

								$result_arr = array();

								foreach ($result as $req) {
									$assignDate = strtotime($req["assignedDate"]);
									$today = strtotime(date("y-m-d H:i:s"));
									if($today - $assignDate >= 604800){
										//create notification
										$createNoti = new createNotification(ADTECH::getDB());
										$nofi_param = array($req["rid"].str_replace(' ', '',$req["assignedTo"]),null,2,"Request Overdue","Request (".$req["rid"].") that assigned to ".$req["assignedTo"]." is overdued, reassign if necessary");
										$createNoti->setParam($nofi_param);
										$createNoti->execute();

										array_push($result_arr, '<tr><th scope="row"><a class="view" href="viewRequest.php?v='.$req["rid"].'">'.$req["rid"].'</a></th><td class="text-left">'.$req["assignedTo"].'</td><td class="text-left">'.$req["assignedDate"].'</td><td class="text-left action"><button type="button" class="btn btn-sm btn-main reassignBtn" data-toggle="modal" data-rid="'.$req["rid"].'" data-target="#reassignDiv">Reassign</button></td></tr>');
									}
								}


								if(sizeof($result_arr) > 0){
									echo '<thead><tr><th>Request #</th><th class="text-left">IT Technician</th><th class="text-left">Assigned Date</th><th class="text-left">Action</th></tr></thead><tbody>';
									foreach ($result_arr as $tr) {
										echo $tr;
									}
									echo '</tbody>';
								}else{
									echo '<span class="empty-text">No Overdue Request</span>';
								}

								echo '</table></div></div></div></div>';
							}
						?>
					
										
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
  	<!-- Node Socket JS -->
  	<script type="text/javascript" src="../assets/js/socket.js"></script>

	<script type="text/javascript">
		$("#footer").load("../assets/snippet/footer.html");

		var rid;
		var uid = <?php echo '"'. $userObj->getData()["id"] .'"' ?>;
		var position = <?php echo '"'. $userObj->getPermissionID() .'"' ?>;
		 <?php if(isset($result_arr)) echo "var overdueSize =". sizeof($result_arr) ?>;

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

		$(document).ready(function(){
			$('.loading-wrapper').addClass('hide');
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawColumnChart);
			google.charts.setOnLoadCallback(drawPieChart);

			getNotification();

			$(".reassignBtn").click((event)=>{
				rid = event.currentTarget.getAttribute( "data-rid" );
				$.ajax({
		          type: "POST",
		          dataType: "json",
		          url: "../assets/php/classes/run.php?a=getStaffList", 
		          success: function(data) {
		            $("#staff_sel")[0].innerHTML = '<option value="0">Select a staff</option>';
		            data[1].forEach((staff)=>{
		            	$("#staff_sel").append('<option value="'+staff["sid"]+'">'+staff["name"]+' (' + staff["freq"] + ')</option>');
		            });
		          }
		      	});
			});

			$("#reassignCom").click(()=>{
				if($("#staff_sel").val() != 0){
					$.ajax({
			          type: "POST",
			          dataType: "json",
			          url: "../assets/php/classes/run.php?a=assignStaff",
			          data:{
			          	sid: $("#staff_sel").val(),
			          	rid: rid
			          },
			          success: function(data) {
			            if(data[0] == true){
			            	location.reload();
			            }

			          }
			      	});
				}
			});
		    function loadDashboard(){
		    	$('.loading-wrapper').removeClass('hide');
	    		$.ajax({
			        type: "POST",
			        dataType: "json",
			        url: "asset/php/loadDashboard.php", 
			        data: {
			            status: true
			        },
			        success: function(data){
			            if(data.status == true){
			            	feedbackArray = [];
			            	//feedbackArray = data.feedback;
			            	
			            	//console.log(feedbackArray.length);
			            	//console.log(feedbackArray);

			            	google.charts.load('current', {'packages':['corechart']});
		        			google.charts.setOnLoadCallback(drawColumnChart);
		        			google.charts.setOnLoadCallback(drawPieChart);

		        			$('.loading-wrapper').addClass('hide');
			            }
			        }
			    });
		    }

		    function drawColumnChart(){
		    	var data = new google.visualization.DataTable();
				data.addColumn('string', 'IT Technician');
				data.addColumn('number', 'Overtime Working Hours (Hr)');
				data.addColumn({type:'string', role:'annotation'});
				data.addColumn('number', 'Overtime Pay (RM)');
				data.addColumn({type:'string', role:'annotation'});
				var overtimeArray = [];
				$.ajax({
		              type: "POST",
		              dataType: "json",
		              url: "../assets/php/classes/run.php?a=getStaffDetails", 
		              success: function(result) {
		                result.forEach((staff)=>{
		                	overtimeArray.push({ '0': staff["fname"], '1': parseFloat((staff["overtime"]/3600).toFixed(2)) , '2': "#2487ce", '3': parseFloat((staff["overtime"]*0.00556).toFixed(2)) , '4': "#dc3545" });
		                });
		                var i = 0;
						for(;overtimeArray[i];){
							data.addRows([
								[overtimeArray[i][0], overtimeArray[i][1], overtimeArray[i][1]+"hr", overtimeArray[i][3], "RM" + overtimeArray[i][3]]
							]);
							i++;
						}

					    var view = new google.visualization.DataView(data);

					      var options = {
					        bar: {groupWidth: "80%"},
					        legend: { position: "bottom" },
					          width: 520,
					          height: 220,
					          series: {
					            0: {targetAxisIndex: 0},
					            1: {targetAxisIndex: 1}
					          },					         
					          vAxes: {
					            // Adds titles to each axis.
					            0: {title: 'Overtime Working Hours'},
					            1: {title: 'Overtime Pay'}
					          },
					          annotations:{
					          	highContrast: true,
					          	alwaysOutside: true,
					          	stem:{
					          		length: 5
					          	}
					          },
					          tooltip:{
					          	trigger: 'none'
					          }
					          
					      };

					      var chart = new google.visualization.ColumnChart(document.getElementById("column-chart"));
					      chart.draw(view, options);
		              }
		         });			
		    }

		    function drawPieChart(){
		    	var data = new google.visualization.DataTable();
				data.addColumn('string', 'Rating');
				data.addColumn('number', 'Number of Customer');
				var feedbackArray = [];
				var star = [0,0,0,0,0];

				$.ajax({
		              type: "POST",
		              dataType: "json",
		              url: "../assets/php/classes/run.php?a=reviewedRequset", 
		              data:{
		              	status: "reviewed"
		              },
		              success: function(result) {
		              	console.log(result);

		                result.forEach((request)=>{
		                	console.log(parseInt(request["review"]));
		                	star[parseInt(request["review"]) - 1] += 1;
		                });

		                console.log(star);

		                // Perfect, Good, Okay, Terrible
						feedbackArray = [
							{ '0': "1 Star", '1': star[0] },
							{ '0': "2 Stars", '1': star[1] },
							{ '0': "3 Stars", '1': star[2] },
							{ '0': "4 Stars", '1': star[3] },
							{ '0': "5 Stars", '1': star[4] }
						];

					   	var i = 0;
						for(;feedbackArray[i];){
							data.addRows([
								[feedbackArray[i][0], feedbackArray[i][1]]
							]);
							i++;
						}

						var options = {
							is3D: true,
							legend: {
								textStyle: {
									fontName: 'Roboto, sans-serif',
									bold: true
								}
							},
							sliceVisibilityThreshold:0,
							width: 500,
							height: 300
						}; 

			            var chart = new google.visualization.PieChart(document.getElementById('pie-chart'));
			            chart.draw(data, options);
		              }
		         });
		    }
    	});

	</script>
</body>
</html>