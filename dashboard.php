<?php

?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  	
  	<!-- Bootstrap 4 CSS -->
  	<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap.min.css"></link>
  	<!-- Our Custom CSS -->
  	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
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
	<!-- Sidebar -->
	<nav class="sidebar"></nav>
	<!-- Page Content -->
	<div class="content">
  		<!-- Header -->
  		<header class="header"></header>
		<!-- Main Content -->
		<main class="main container-fluid">
			<div class="row">

				<div class="page-title-wrapper col-12">
					<span class="page-title">CEO Dashboard</span>
				</div>
				
				<div class="col-12 dashboard">
					<div class="row">
						<div class="home-container-wrapper col-6">
							<div class="home-container">
								<div class="row">
									<div class="col-12">
										<h5>Monthly Report</h5>
									</div>
								</div>
								<div class="row">
									<div class="col-8">
										<span>New Requets:</span>
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
										<span>Ongoing Requets:</span>
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
										<span>Completed Requets:</span>
									</div>
									<div class="col-4">
										<div>
											<span>40</span>
											<span>request</span>
										</div>
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
						</div>
						<div class="home-container-wrapper col-6">
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
						</div>
					</div>
					<div class="row">
						<div class="home-container-wrapper col-6">
							<div class="home-container">
								<div class="row">
									<div class="col-12">
										<h5>Overall Request Rating by Client</h5>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<div id="pie-chart"></div>
									</div>
								</div>
								<div class="row">
									<div class="col-12 text-right">
										<button type="button" class="btn btn-primary" id="">View Details >></button>
									</div>
								</div>
							</div>
						</div>
						<div class="home-container-wrapper col-6">
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
					                                    <th class="text-center">IT Techncian</th>
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
					                        </table>
					                    </div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
	           	</div>
			</div>
		</main>
  	</div>

  	<!-- Jquery JS -->
	<script type="text/javascript" src="assets/vendor/jquery/jquery.min.js"></script>
	<!-- Bootstrap JS -->
	<script type="text/javascript" src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!-- Google Chart API JS -->
  	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">
		$(document).ready( function () {
			$('.loading-wrapper').addClass('hide');
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawColumnChart);
			google.charts.setOnLoadCallback(drawPieChart);

		    function loadDashboard() {
		    	$('.loading-wrapper').removeClass('hide');
	    		$.ajax({
			        type: "POST",
			        dataType: "json",
			        url: "asset/php/loadDashboard.php", 
			        data: {
			            status: true
			        },
			        success: function(data) {
			            if(data.status == true) {

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

		    function drawColumnChart() {
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
				for (;overtimeArray[i];) {
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

		    function drawPieChart() {
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
				for (;feedbackArray[i];) {
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