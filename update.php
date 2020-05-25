<?php

include('conn.php');
  
  session_start();
    $email = $_SESSION['user'];
    $id = $_SESSION['id']; 
  
    if(!isset($_SESSION['user'])){
      header('location:index.php');
    }


  if(isset($_POST['update'])){
    $eType = trim(mysqli_real_escape_string($conn, $_POST['eType']));
    $eName = trim(mysqli_real_escape_string($conn, $_POST['eName']));
    $eVenue= trim(mysqli_real_escape_string($conn, $_POST['eVenue']));
    $eDate = trim(mysqli_real_escape_string($conn, $_POST['eDate']));
    $eTime = trim(mysqli_real_escape_string($conn, $_POST['eTime']));
    $ePriority = trim(mysqli_real_escape_string($conn, $_POST['ePriority']));
    $synopsis = trim(mysqli_real_escape_string($conn, $_POST['synopsis']));


    $sql_u = "UPDATE todo_list SET event_type='$eType', event_name='$eName', event_venue='$eVenue', event_date='$eDate', event_time='$eTime', event_priority='$ePriority', synopsis='$synopsis' WHERE id='$id' ";
    $option_u = mysqli_query($conn, $sql_u);
      if(!$option_u){
        exit('error when trying to update your event');
      } else{
        ?>
        <script>
            var x=window.onbeforeunload;
            // logic to make the confirm and alert boxes
            if (confirm("event successifuly updated!!!") == true) { 
                window.location.href = "trial.php";
            }
            else{
            window.location.href = "update.php";
            }
        </script>
        <?php
      }
      header('location:trial.php');
  }
  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>daily events</title>
    <!--bootsrap css -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <!-- fontAwsome -->
    <script src="./js/all.js"></script>
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Jomolhari&display=swap" rel="stylesheet">
    <!-- main css -->
    <link rel="stylesheet" href="../css/main.css">

</head>
<style type="text/css">
  a:hover{
    text-decoration: none;
  }
  #top{
    top: 0;
    left: 0;
    width: 100%;
    height: 40px;
    background: #fff;
    transition: 1s;
    box-shadow: 0px 9px 10px -12px rgba(0, 0, 0, 0.8);
  }
  nav ul{
    list-style: none;
  }
  nav ul li{
    float: right;
  }
  #image{
    border-radius: 50%;
    height: 30px;
    width: 28px;
    margin-top: -3px;
    margin-left: 7px;
  }
  #sign_out{
    margin-top: 4px;
    height: 20px;
    width: 20px;
  }
</style>
<body>

 <!-- navigation -->
 <section>
      <nav class="navbar-fixed-top"id="top">
        <div class="container py-2">
          <ul class="nav-pills">
            <?php
              require_once('conn.php');
              $nav = "SELECT * FROM uses WHERE email = '$email'";
              $opt_nav = mysqli_query($conn, $nav);
                while($nav_fetch = mysqli_fetch_assoc($opt_nav)){
                  $user_n = $nav_fetch['user_name'];
                  $nav_dp = $nav_fetch['img'];                 
                }
            ?>

            <li class="nav-item mr-3"><a href="signOut.php"><span class="fas fa-sign-out-alt ml-5" id="sign_out"></span></a></li>
            <li class="nav-item mr-3"><h6 class="text-capitalize" style="font-size: 13px; margin-top: 10px;"><?php echo $user_n ?></h6></li>
            <li class="nav-item mr-2"><img src="img/<?php echo $nav_dp?>" alt="" id="image"></li>
          </ul> 
        </div>     
      </nav>
    </section>

    <!-- update -->
    <div class="row">
        <div class="col-md-2"></div>
            <div class="col-md-10">
            <div class="card mt-5 py-4 pl-2" style="box-shadow: 2px 8px 7px -5px rgba(0, 0, 0, 0.5)">
              <div class="modal-header border-0">
                <h5 class="mb-1 text-center"><a class="h5 text-primary text-capitalize font-weight-bolder">update event</a></h5>
              </div>
                    <div class="row">
                    <div class="col-3 pl-5">
                        <div class="pt-3">
                        <h6 class="ml-2 text-capitalize">event type</h6>
                        </div>
                        <div class="pt-3 ">
                        <h6 class="ml-2 text-capitalize">event name</h6>
                        </div>
                        <div class="pt-4 ">
                        <h6 class="ml-2 text-capitalize">event venue</h6>
                        </div>
                        <div class="pt-3 ">
                        <h6 class="ml-2 text-capitalize">event date</h6>
                        </div>
                        <div class="pt-4 ">
                        <h6 class="ml-2 text-capitalize">event time</h6>
                        </div>
                        <div class="pt-3 ">
                        <h6 class="ml-2 text-capitalize">event priority</h6>
                        </div>
                        <div class="pt-4 ">
                        <h6 class="ml-2 text-capitalize">synopsis</h6>
                        </div>
                    </div>
                    <div class="col-8 ml-0">
                        <form action="update.php" method="POST" enctype="multipart/form-data">
                        <select name="eType" id="" class="form-control mt-2">
                            <option value="Work">Work</option>
                            <option value="Fun">Fun</option>
                            <option value="Academic">Academic</option>
                            <option value="Leisure">Leisure</option>
                            <option value="Family">Family</option>
                            <option value="Friends">Friends</option>
                            <option value="Religion">Religion</option>
                        </select>
                        <input type="text" name="eName" class="form-control mt-2"style="height: 40px;">
                        <input type="text" name="eVenue" class="form-control mt-2"style="height: 40px;">
                        <input type="date" name="eDate" class="form-control mt-2"style="height: 40px;">
                        <input type="text" name="eTime" class="form-control mt-2"style="height: 40px;">
                        <select name="ePriority" id="" class="form-control mt-2">
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                        <textarea name="synopsis" id="" class="form-control mt-2" style="height: 70px;"></textarea>
                        <button type="submit" class="btn btn-primary btn-block mt-3 p-1" name="update"style="height: 30px;">Save</button>
                        </form>
                    </div>
                    <!-- <div class="col-md-1"></div> -->
                    </div>
                </div>            
            </div>
        <div class="col-md-1"></div>
    </div>
    <!-- /update -->



  
  </body>
</html>

    
    <!--jquery-->
    <script src="./js/jquery-3.4.1.min.js"></script>
    <!--bootsrap js-->
    <script src="./js/bootstrap.bundle.min.js"></script>

</body>
</html>