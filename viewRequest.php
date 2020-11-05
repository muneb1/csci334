<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>View Request:AdTech IT Consulting</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: OnePage - v2.1.0
  * Template URL: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  <div id="alert-div">
    
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="index.php">AdTech IT Consulting</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="index.php#about">About</a></li>
          <li><a href="index.php#team">Team</a></li>
          <li><a href="index.php#pricing">Pricing</a></li>
          <li><a href="index.php#contact">Contact</a></li>

          <?php
            session_start();
            if(isset($_SESSION["uid"])){
              if((int)$_SESSION["groupID"] != 1){
                header("Location: assets/php/classes/run.php?a=logout");
              }
              require "assets/php/classes/build.php";
              $userFac = new userFactory();
              $userObj = $userFac->getUser($_SESSION["groupID"], $_SESSION["uid"]);

              echo '<li class="drop-down"><a href="">'.$userObj->getData()["name"].'</a>
            <ul>
              <li><a type="button" data-toggle="modal" data-target="#newResquest">New Request</a></li>
              <li><a href="requestHistory.php">Request History</a></li>
              <li><a href="#">Account</a></li>
              <li class="logout"><a href="assets/php/logout.php">Logout</a></li>
            </ul>
          </li>';
             require_once "assets/php/classes/build.php";
              require_once "assets/php/classes/command.php";

              $getRequest = new getRequest(AdTech::getDB());
              $getRequest->setParam([$_SESSION["uid"],$_GET["v"]]);
              $data = json_decode($getRequest->execute())->{"1"}[0];

            }else{
              header("Location: index.php");
            }
          ?>

        </ul>
      </nav><!-- .nav-menu -->

      <!-- <a href="#about" class="get-started-btn scrollto">Get Started</a> -->

    </div>
  </header><!-- End Header -->
  <div class="modal fade" id="newResquest" tabindex="-1" role="dialog" aria-labelledby="newResquest" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="newResquest">New Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group row">
                <label for="subject" class="col-sm-2 col-form-label">Subject</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="subject" placeholder="Subject">
                </div>
              </div>
              <div class="form-group row">
                <label for="content" class="col-sm-2 col-form-label">Request</label>
                <div class="col-sm-10">
                  <textarea type="password" rows="5" class="form-control" id="content" placeholder="Enter your request description here"></textarea>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-main" id="submitRequest">Submit</button>
          </div>
        </div>
      </div>
  </div>
  <main id="main">
    <section>
      <div class="container">
        <div class="row no-gutters">
          <div class="col-9 conversation client">
            <h2><?php echo $data->{"subject"}." (" . $data->{"rid"} . ")"?></h2>
            <hr>
            <div class="row">
              <div class="col-2">
                <span>Description: </span>
              </div>
              <div class="col-10">
                <span><?php echo $data->{"description"} ?></span>
              </div>
            </div>
            <div id="replies"></div>
            <div class="replyDiv client">
              <div class="d-flex justify-content-between align-items-center">
                <b>Enter your reply:</b>
                <?php 
                  if ($data->{"status"} <= 2 || $data->{"status"} > 4){
                    echo '<button class="btn btn-sm btn-main" disabled id="replyBtn">Reply</button>';
                  } else{
                    echo '<button class="btn btn-sm btn-main" id="replyBtn">Reply</button>';
                  }

                ?>
                
              </div>
              <?php 
                if ($data->{"status"} <= 2){
                  echo '<textarea rows="5" disabled id="replyContent"></textarea>';
                } else if ($data->{"status"} > 4){
                  echo '<textarea rows="5" disabled id="replyContent">The request is closed, you can’t reply any more. Please create a new request if you faced a new issue.</textarea>';
                } else{
                  echo '<textarea autofocus rows="5" id="replyContent"></textarea>';
                }

              ?>
                
              
            </div>
          </div>
          <div class="col-3 progressDiv client">
            <div>
              <b>Request status:</b>
              <ul class="progressList">
                <li class="checked">Request created<span class="time"><?php echo $data->{"createdDate"} ?></span></li>
                <?php 
                  if($data->{"status"} == 1) {
                    echo '<li>Waiting for IT Technician</li>';
                  }else{
                    echo '<li class="checked">IT technician assigned<span class="time">'.$data->{"assignedDate"}.'</span><span><b>'.$data->{"assignedTo"}.'</b> will help you to solve the issue.</span></li>';
                  }
                  if($data->{"status"} == 5) {
                    echo '<li class="checked">Issue resolved<span class="time">'.$data->{"completedDate"}.'</span></li>';
                  }else{
                    echo '<li>Issue resolved<span class="time"></span></li>';
                  }
                ?>
              </ul>
              <?php
                if($data->{"status"} == 5){
                  echo '<b>Service review:</b><span>Please rate our service and give us a comment below</span>';
                  echo '<div class="stars"><div class="star" data-star="1"></div><div class="star" data-star="2"></div><div class="star" data-star="3"></div><div class="star" data-star="4"></div><div class="star" data-star="5"></div></div>';
                  echo '<b>Please leave a comment:</b><textarea rows="4" id="reviewContent"></textarea>';
                  echo '<button class="btn btn-sm btn-main" style="float: right" id="subReviewBtn">Submit Review</button>';
                }else if($data->{"status"} == 6){
                   echo '<b>Service review:</b><span>Please rate our service and give us a comment below</span>';
                  echo '<div class="stars">';
                  for($i = 1; $i <= 5; $i++){
                    if($i <= $data->{"review"}){
                      echo '<div class="star active" data-star="'.$i.'"></div>';
                    }else{
                      echo '<div class="star" data-star="'.$i.'"></div>';
                    }
                  }
                  echo '</div><b>Please leave a comment:</b><textarea disabled rows="4" id="reviewContent">'.$data->{"comment"}.'</textarea>';
                  echo '<span class="float-right">Reviewed by: '.$data->{"reviewedDate"}.'</span>';
                }
              ?>

            </div>
            
          </div>
        </div>
      </div>
        
    </section>
    

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>AdTech IT Consulting</h3>
            <p>
              No 301, Level 30,<br>
              Menara Prestige, 50450 Kuala Lumpur,<br>
              Federal Territory of Kuala Lumpur  <br><br>
              <strong>Phone:</strong> +603 - 1234 5678<br>
              <strong>Email:</strong> info@adtech.com.my<br>
            </p>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Join Our Newsletter</h4>
            <p>Be the first to have our latest informations</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>
          </div>

        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">

      <div class="mr-md-auto text-center text-md-left">
        <div class="copyright">
          &copy; Copyright <strong><span>AdTech IT Consulting</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/ -->
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/counterup/counterup.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/sha256.js"></script>
  <script src="assets/js/main.js"></script>
  <script type="text/javascript">
    var rid = <?php echo $_GET["v"] ?>;
    var uid = <?php echo '"'.$userObj->getData()["id"].'"'?>;
    var status = <?php echo $data->{"status"} ?>;

    $(".close-modal").click(()=>{
      location.href = "requestHistory.php";
    });

    if(status >= 5){
      $("#subReviewBtn").click(()=>{
        var reviewContent = $("#reviewContent").val();
        var starCount = 0;
        starCount = $(".star.active").length;
        if(reviewContent != "" && starCount != 0){
          $.ajax({
              type: "POST",
              dataType: "json",
              url: "assets/php/classes/run.php?a=submitReview", 
              data: {
                comment: reviewContent,
                star: starCount,
                rid: rid
              },
              success: function(data) {
                if(data == true){
                   location.reload();
                }
              }
          });
        }
  
      });
    }

    $(document).ready(()=>{
      getReply(rid);
      $("#submitRequest").click(()=>{
        if($("#subject").val() == "" && $("#content").val() == ""){
          createAlert("danger", "Request subject and content can't empty!");
        }else if($("#subject").val() == ""){
          createAlert("danger", "Request subject can't empty!");
        }else if($("#content").val() == ""){
          createAlert("danger", "Request content can't empty!");
        }else{
         $.ajax({
              type: "POST",
              dataType: "json",
              url: "assets/php/classes/run.php?a=createRequest", 
              data: {
                subject: $("#subject").val(),
                content: $("#content").val()
              },
              success: function(data) {
                if(data[0] == false){
                  createAlert("danger", "Request failed to submit");
                }else{
                  createAlert("success", "Request submited successful");
                  setTimeout(()=>{location.reload()},500);
                }
              }
          });
        }
      });

      $("#replyBtn").click(()=>{
        if($("#replyContent").val() != ""){
          $.ajax({
              type: "POST",
              dataType: "json",
              url: "assets/php/classes/run.php?a=addReply", 
              data: {
                rid: rid,
                content: $("#replyContent").val(),
                uid: uid
              },
              success: function(data) {
                if(data[0] == true){
                  getReply(rid);
                  $("#replyContent").val("");
                }
              }
          });
        }
      });
    });
    
    function getReply(requestID){
      $.ajax({
          type: "POST",
          dataType: "json",
          url: "assets/php/classes/run.php?a=getReplies", 
          data: {
            rid: requestID
          },
          success: function(data) {
            var tempStr = "";
            $("#replies")[0].innerHTML = "";
            data[1].forEach((reply)=>{
              tempStr = '<div class="d-flex justify-content-between align-items-baseline conDiv"><div>';
              if(reply["creator"] == null){
                tempStr += '<span class="title">System</span>';
              }else{
                if(reply["groupping"] == 0){
                  tempStr += '<span class="title">IT Technician ('+capitalizeFirstLetter(reply["creator"])+')</span>';
                }else{
                  tempStr += '<span class="title">You</span>';
                }
                
              }
            
              tempStr += '<span class="content">'+reply["content"]+'</span>';
              tempStr += '</div><span>'+reply["createdTime"]+'</span></div>';
              $("#replies").append(tempStr);
            });
          }
      });
    }

    function createAlert(type, content){
      $("#alert-div").prepend('<div class="alert alert-'+type+' alert-dismissible fade show" role="alert">'+content+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    }

    if(status == 5){
      var rated = false;

      $(".star").mouseenter((event)=>{
        for(var i = 0; i < event.currentTarget.getAttribute("data-star"); i++){
          $(".star")[i].classList.add("active");
        }
        if(rated == true){
            $(".star").mouseleave((event)=>{
              for(var i = 0; i < 5; i++){
                 $(".star")[i].classList.remove("active");
              }
            });

        }
      });
      $(".star").mouseleave((event)=>{
        for(var i = 0; i < 5; i++){
          $(".star")[i].classList.remove("active");
        }
      });

      $(".star").click((event)=>{
        for(var i = 0; i < event.currentTarget.getAttribute("data-star"); i++){
            $(".star")[i].classList.add("active");
        }

        $(".star").off("mouseleave");
        rated = true;
      });
    }

      

    function capitalizeFirstLetter(string) {
      return string.split(' ').map(capitalize).join('_');
    }
    
    function capitalize(str) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    }

    
  </script>
</body>

</html>