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
	<title>Dashboard</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

	<!-- Bootstrap 4 CSS -->
  	<link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.min.css"></link>
  	<link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css"></link>
</head>
<body>

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
								echo '<li class="" href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><a>Customer Requests</a><ul class="collapse list-unstyled" id="homeSubmenu">';
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

				<div class="text-right">
					<span><?php echo $userObj->getData()["fname"] . " " . $userObj->getData()["lname"] ." (". $userObj->getData()["position"] . ")"?></span>
					<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-down" class="svg-inline--fa fa-caret-down fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
						<path fill="currentColor" d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"></path>
					</svg>
				</div>
			</header>

			<!-- Content -->
			<div class="align-items-stretch content">
				<!-- Main Content -->
				<main class="row no-gutters p-4">
					<h1 class="page-title col-12"><?php echo $userObj->getData()["position"] . " Dashboard" ?></h1>
					<div class="dashboard col-12">
						<div class="home-container">
							<div class="row">
								<div class="col-12">
									<h5>Monthly Report</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-8">
									<span>New Requests:</span>
								</div>
								<div class="col-4">
									<div>
										<span>3</span>
										<span>request</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-8">
									<span>On-Going Requests:</span>
								</div>
								<div class="col-4">
									<div>
										<span>19</span>
										<span>request</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-8">
									<span>Completed Requests:</span>
								</div>
								<div class="col-4">
									<span>40</span>
									<span>request</span>
								</div>
							</div>
							<div class="row">
								<div class="col-8">
									<span>Average Time to Close Request:</span>
								</div>
								<div class="col-4">
									<div>
										<span>1 hr 23 mins</span>
									</div>
								</div>
							</div>
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
									<button type="button" class="btn btn-primary" id="">View Details >></button>
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
							<div class="row">
								<dir class="col-12 text-right">
									<button type="button" class="btn btn-primary" id="">View Details</button>
								</dir>
							</div>
						</div>
						<div class="home-container">
							<div class="row">
								<div class="col-12">
									<h5>Overtime Working Hours of IT Technician</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<div class="table-responsive">
										<table id="table-request" class="table">
											<thead>
												<tr>
													<th>Request #</th>
													<th class="text-center">IT Technician</th>
													<th class="text-center">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th scope="row">20200919016</th>
													<td class="text-center">Carly Mikey</td>
													<td class="text-center">
														<button type="button" class="btn btn-primary" id="">Reassign</button>
													</td>
												</tr>
												<tr>
													<th scope="row">20200919015</th>
													<td class="text-center">Alice Bob</td>
													<td class="text-center">
														<button type="button" class="btn btn-primary" id="">Reassign</button>
													</td>
												</tr>
												<tr>
													<th scope="row">20200919013</th>
													<td class="text-center">Catty Dog</td>
													<td class="text-center">
														<button type="button" class="btn btn-primary" id="">Reassign</button>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
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
	<script type="text/javascript" src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!-- Google Chart API JS -->
  	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">
		$("#footer").load("../assets/snippet/footer.html");

		$(document).ready(function(){
			$('.loading-wrapper').addClass('hide');
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawColumnChart);
			google.charts.setOnLoadCallback(drawPieChart);

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
				data.addColumn('number', 'Overtime Working Hours');
				data.addColumn({ role: "style" });
				
				// Perfect, Good, Okay, Terrible
				overtimeArray = [
					{ '0': "Alice", '1': 3.6 , '2': "#5B9BD5" },
					{ '0': "Bob", '1': 2.8, '2': "#ED7D31" },
					{ '0': "Catty", '1': 1.6, '2': "#19A979" },
					{ '0': "Dog", '1': 5.0, '2': "#A5A5A5" }
				];

				var i = 0;
				for(;overtimeArray[i];){
					data.addRows([
						[overtimeArray[i][0], overtimeArray[i][1], 'color: ' + overtimeArray[i][2]]
					]);
					i++;
				}

			    var view = new google.visualization.DataView(data);
			    view.setColumns([0, 1,
					{ calc: "stringify",
					sourceColumn: 1,
					type: "string",
					role: "annotation" },
				2]);

			      var options = {
			        bar: {groupWidth: "90%"},
			        legend: { position: "none" },
			      };

			      var chart = new google.visualization.ColumnChart(document.getElementById("column-chart"));
			      chart.draw(view, options);
		    }

		    function drawPieChart(){
		    	var data = new google.visualization.DataTable();
				data.addColumn('string', 'Rating');
				data.addColumn('number', 'Number of Customer');
				
				// Perfect, Good, Okay, Terrible
				feedbackArray = [
					{ '0': "Perfect", '1': 36 },
					{ '0': "Good", '1': 28 },
					{ '0': "Okay", '1': 16 },
					{ '0': "Terrible", '1': 5 }
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
					}
				}; 

	            var chart = new google.visualization.PieChart(document.getElementById('pie-chart'));
	            chart.draw(data, options);
	            
	            //chart.draw(data);
		    }
    	});
	</script>
</body>
</html>