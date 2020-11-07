<?php
   session_start();

  if(isset($_SESSION["uid"])){
    if((int)$_SESSION["groupID"] != 0){
      header("Location: ../assets/php/classes/run.php?a=logout&p=admin");
    }else{
      require_once "../assets/php/classes/build.php";
      $userFac = new userFactory();
      $userObj = $userFac->getUser($_SESSION["groupID"], $_SESSION["uid"]);

      if(isset($_GET["v"])){

        $getRequest = new getRequest(AdTech::getDB());
        $getRequest->setParam(["",$_GET["v"]]);
        $data = json_decode($getRequest->execute())->{"1"}[0];

        //change status to going when first view
        if ($data->{"status"} == 2 && $userObj->getData()["fname"] == $data->{"assignedTo"}){
          $requestUpdator = new updateRequest(AdTech::getDB());
          $updateParam = array(3,$_GET["v"]);
          $requestUpdator->setParam($updateParam);
          if($requestUpdator->execute() == true){
            header("Refresh:0");
          }
        }

        $getReply = new getReply(AdTech::getDB());
        $getReply->setParam([$_GET["v"]]);
        $replies = $getReply->execute();
      }
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../assets/vendor/bootstrap/css/bootstrap.min.css"></link>
    <link rel="stylesheet" type="text/css" href="../assets/css/root.css"></link>
    <link rel="stylesheet" type="text/css" href="../assets/css/recordHistory.css"></link>
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
              <a class="dropdown-item" href="#">Account</a>
              <a class="dropdown-item logout" href="../assets/php/classes/run.php?a=logout&p=admin">Logout</a>
            </div>
          </div>
        </div>
      </header>

      <!-- Content -->
      <div class="align-items-stretch content">
        <!-- Main Content -->
        <main class="p-4">
          <div class="row no-gutters">
            <div class="col-9 conversation">
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
              <div class="replyDiv">
                <div class="d-flex justify-content-between align-items-center">
                  <b>Enter your reply:</b>
                  <?php 
                    if (($data->{"status"} == 3 || $data->{"status"} == 4) && $userObj->getData()["fname"] == $data->{"assignedTo"}){
                      echo '<button class="btn btn-sm btn-main" id="replyBtn">Reply</button>';
                    } else{
                      echo '<button class="btn btn-sm btn-main" disabled id="replyBtn">Reply</button>';
                    }

                  ?>
                  
                </div>
                <?php 
                  if (($data->{"status"} == 3 || $data->{"status"} == 4) && $userObj->getData()["fname"] == $data->{"assignedTo"}){
                    echo '<textarea id="replyContent" rows="5" autofocus ></textarea>';
                  } else{
                    echo '<textarea id="replyContent" rows="5" disabled></textarea>';
                  }
                ?>                
              </div>
            </div>
            <div class="col-3 progressDiv">
              <div>
                <b>Request status:</b>
                <ul class="progressList">
                  <li class="checked">Request created<span class="time"><?php echo $data->{"createdDate"} ?></span></li>
                  <?php 
                    if($data->{"status"} == 1) {
                      echo '<li>Waiting for IT Technician</li>';
                    }else{
                      echo '<li class="checked comFlag">IT technician assigned<span class="time">'.$data->{"assignedDate"}.'</span><span><b>'.$data->{"assignedTo"}.'</b> will help you to solve the issue.</span></li>';
                    }
                    if($data->{"status"} >= 5) {
                      echo '<li class="checked">Issue resolved<span class="time">'.$data->{"completedDate"}.'</span></li>';
                    }else{
                      echo '<li>Issue resolved<span class="time"></span></li>';
                    }
                  ?>
                </ul>
                 <?php
                  if($data->{"status"} == 5){
                    echo '<b>Service review:</b><br><span>Waiting client to review</span>';
                    echo '<div class="stars"><div class="star" data-star="1"></div><div class="star" data-star="2"></div><div class="star" data-star="3"></div><div class="star" data-star="4"></div><div class="star" data-star="5"></div></div>';
                    echo '<b>Please leave a comment:</b><textarea disabled rows="4" id="reviewContent"></textarea>';
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

  <script type="text/javascript">
    $("#footer").load("../assets/snippet/footer.html");

    var rid = <?php echo $_GET["v"] ?>;
    var uid = <?php echo '"'.$userObj->getData()["id"].'"'?>;
    var position = <?php echo $userObj->getPermissionID() ?>;
    var status = <?php echo $data->{"status"} ?>;
    var ssid;

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
        }else if(jsonData.msg == "reply"){
          getReply(rid);
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
              if(data[2] == "0"){
                $(".noti-num")[0].style.display = "none";
              }else{
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
      getReply(rid);
      getNotification();
      $('.loading-wrapper').addClass('hide');

       if(status >= 2 && status <= 4 && position == 3){
        $(".comFlag").append("<button class='btn btn-sm btn-main' id='comBtn'>Resolved</button>");
        $("#comBtn").click(()=>{
          $.ajax({
              type: "POST",
              dataType: "json",
              url: "../assets/php/classes/run.php?a=completeStatus", 
              data: {
                rid: rid
              },
              success: function(data) {
                if(data == 1){
                  console.log(data);
                  window.onbeforeunload = function () {}
                  $.ajax({
                      type: "POST",
                      dataType: "json",
                      url: "../assets/php/classes/run.php?a=updateStatus", 
                      data: {
                        rid: rid,
                        sid: uid,
                        sessid: ssid,
                        clock: "done"
                      },
                      success: function(data) {
                        sock.send('{"action":"notification"}');
                        location.reload();
                      }
                  });
                  
                }
              }
          });
        });
      }

      $("#replyBtn").click(()=>{
        if($("#replyContent").val() != ""){
          $.ajax({
              type: "POST",
              dataType: "json",
              url: "../assets/php/classes/run.php?a=addReply", 
              data: {
                rid: rid,
                content: $("#replyContent").val(),
                uid: uid
              },
              success: function(data) {
                if(data[0] == true){
                  getReply(rid);
                  $("#replyContent").val("");
                  sock.send('{"action":"reply"}');
                }
              }
          });
        }
      });

      if(position == 3 && ( status >= 2 && status <= 4)){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "../assets/php/classes/run.php?a=updateStatus", 
            data: {
              rid: rid,
              sid: uid,
              clock: "in"
            },
            success: function(data) {
              ssid = data[1];
              $(window).on('beforeunload', function(){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "../assets/php/classes/run.php?a=updateStatus", 
                    data: {
                      rid: rid,
                      sid: uid,
                      sessid: ssid,
                      clock: "out"
                    },
                    success: function(data) {
                      console.log(data);
                    }
                });
              });
            }
        });
      }
    });

    function getReply(requestID){
      $.ajax({
          type: "POST",
          dataType: "json",
          url: "../assets/php/classes/run.php?a=getReplies", 
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
                  tempStr += '<span class="title">You</span>';
                }else{
                  tempStr += '<span class="title">Client ('+capitalizeFirstLetter(reply["creator"])+')</span>';
                }
                
              }

              tempStr += '<span>'+reply["content"]+'</span>';
              tempStr += '</div><span>'+reply["createdTime"]+'</span></div>';
              $("#replies").append(tempStr);
            });

            $("#replies").animate({ scrollTop: $("#replies")[0].scrollHeight}, 500);
          }
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