<?php

include('conn.php');
  
  session_start();
  $email = $_SESSION['user'];  

  if(!isset($_SESSION['user'])){
    header('location:index.php');
  }



  if(isset($_POST['myEvents'])) {
    $eType = trim(mysqli_real_escape_string($conn, $_POST['eType']));
    $eName = trim(mysqli_real_escape_string($conn, $_POST['eName']));
    $eVenue= trim(mysqli_real_escape_string($conn, $_POST['eVenue']));
    $eDate = trim(mysqli_real_escape_string($conn, $_POST['eDate']));
    $eTime = trim(mysqli_real_escape_string($conn, $_POST['eTime']));
    $ePriority = trim(mysqli_real_escape_string($conn, $_POST['ePriority']));
    $synopsis = trim(mysqli_real_escape_string($conn, $_POST['synopsis']));
    $status = 0;

    // confirm that the event is not in the system
    $sql_c = "SELECT * FROM todo_list";
      $results = mysqli_query($conn, $sql_c);
      
      while($fetch = mysqli_fetch_assoc($results)) {
        $en = $fetch['event_name'];
        $edt = $fetch['event_date'];

        if(date("Y-m-d") > $eDate){
          exit('This event is out of date confirm the date please');
        }
        elseif($eName === $en && $eDate === $edt) {
          die('the event is already in your list');
       }
        elseif(empty($eName)) {
          die('please enter the event name');
       }
          
      }

      $add_sql = "INSERT INTO todo_list (event_type, event_name, event_venue, event_date, event_time, event_priority, synopsis, status) VALUES ('$eType', '$eName', '$eVenue', '$eDate', '$eTime', '$ePriority', '$synopsis', '$status')";
      $option = mysqli_query($conn, $add_sql);

      if(!$option) {
          exit('An error occured');
      }
      else{
          echo('the todo_list has been sucessifully added');
        
     }

  }
  
  
?>

<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
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
    <!--sweet alert-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
<body class="">

<script type="text/javascript">
  // let today = new Date();
  // let date = today.getFullYear();
  // let time = today.getHours();
  // var dateTime = date + ' ' + time;
</script>

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
            <li class="nav-item mr-2"><img src="img/<?php echo $nav_dp;?>" alt="" id="image"></li>
          </ul> 
        </div>     
      </nav>
    </section>
  
    <!-- page title -->
    <section class="page-title-section overlay bg-info py-4 mt-4" data-background="images/backgrounds/page-title.jpg">
    <div class="container">
        <div class="row">
        <div class="col-md-8">
            <ul class="list-inline custom-breadcrumb">
            <li class="list-inline-item"><a class="h2 text-white font-secondary" style="font-family: goudy stout;">Planner</a></li>
            </ul>
            <p class="text-secondary font-italic">This is a web application that helps you to plan for your daily Events and Activities.</p>
        </div>
        <div class="col-4">
          <h3 class="text-white font-weight-lighter" style="font-family: freestyle script;">Today's date</h3>
          <h6 class=" font-weight-lighter text-muted"><span style="font-family: arial narrow;"><?php  echo date("l"); ?></span>...<span style="font-family: castellar;"> <?php echo date("d-m-Y"); ?></span></h6>
        </div>
        </div> 
    </div>
    </section>
    <section class="mt-3">
      <div class="container">
      <p class=" mb-1list-inline-item"><a class="h6 text-info font-secondary" href="@@page-link">Quick view</a></p>
        <button class="btn px-4 btn-outline-primary" href="#" data-toggle="modal" data-target="#today">Today</button>
        <button class="btn px-4 btn-outline-warning" href="#" data-toggle="modal" data-target="#upcoming">Upcoming</button>
        <button class="btn px-4 btn-outline-success" href="#" data-toggle="modal" data-target="#done">Done</button>
        <button class="btn px-4 btn-outline-danger"  href="#" data-toggle="modal" data-target="#notDone">Not done</button>
        <button class="btn px-4 btn-outline-secondary" href="#" data-toggle="modal" data-target="#high">High  </button>          
        <button class="btn px-4 btn-outline-info" href="#" data-toggle="modal" data-target="#medium">Medium</button>
        <button class="btn px-4 btn-outline-warning"  href="#" data-toggle="modal" data-target="#low">Low</button> 
      </div>
    </section>
    <!-- /page title -->
    <div class="m-5">
      <div class="row">
        <div class="col-12">
                <a style="height: 35px; width: 150px; float: right;" class="btn btn-outline-primary ml-sm-3 d-sm-block p-1" href="#" data-toggle="modal" data-target="#addTeacherModal">add events <span class="fas fa-arrow-right py-auto"></span> </a>
            </div>
          </div>
        </div>
    </div>
    </div>  
   <!-- event listing -->
    <?php
      $sqe = "SELECT * FROM todo_list";
      $opt = mysqli_query($conn, $sqe);

      $entries = mysqli_num_rows($opt);
    ?>
   <div class="container bg-muted rounded">
      <div class="pb-1 border-info" style="border-left: solid 1px; border-bottom: solid 1px; border-right: solid 1px;">
        <div class="container-fluid bg-info p-2 mb-3">
          <h6 class="text-white pl-2">ALL EVENTS <span class="ml-5 font-weight-lighter text-capitalize mt-2"><script>document.write(new Date());</script></span></h6>
        </div>
        <p class="mx-4">Shows <select class="pl-3" style="width: 60px; text-align: center;"><option value=""><?php echo $entries?></option></select> entries</p>
        <?php
            if(isset($_GET['success']) && $_GET['success'] == 1){
                ?>
                <script>
                    swal({
                        title: "Done!",
                        text: "The event has been saved!",
                    })
                </script>
                <?php
            }
        ?>
        
        <p id="line" style="border-bottom: solid 2px; margin-bottom: 0px; margin-left: 23px; margin-right: 23px;"></p>

        <div class=" bg-light mx-4">
          <table class="table table-hover table-bordered">
            <thead style="height: 40px;">
              <tr class="text-primary">
                <th class="text-capitalize text-center" >view</th>
                <th class="text-capitalize text-center" > name</th>
                <th class="text-capitalize text-center" > venue</th>
                <th class="text-capitalize text-center" > date</th>
                <th class="text-capitalize text-center" > time</th>
                <th class="text-capitalize text-center" >synopsis</th>
                <th class="text-capitalize text-center" >priority</th>
                <th class="text-capitalize text-center" >action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              
                $ql_f = "SELECT * FROM todo_list";
                $results_f = mysqli_query($conn, $ql_f);

                while($row_f = mysqli_fetch_assoc($results_f)) {
                  $id = $row_f['id'];
                  $name = $row_f['event_name'];
                  $venue = $row_f['event_venue'];
                  $date = $row_f['event_date'];
                  $time = $row_f['event_time'];
                  $priority = $row_f['event_priority'];
                  $synopsis = $row_f['synopsis'];
                  $status = $row_f['status'];
                  ?>
                    <tr>
                      <td class="text-capitalize"><span class="fas fa-arrow-right ml-2 text-success"></span></td>
                      <td class="text-capitalize"><small><?php echo $name?></small></td>
                      <td class="text-capitalize"><small><?php echo $venue?></small></td>
                      <td class="text-capitalize"><small><?php echo $date?></small></td>
                      <td class="text-capitalize"><small><?php echo $time?></small></td>
                      <td class="text-capitalize"><small><?php echo $synopsis?></small></td>
                      <td class="text-capitalize"><small><?php echo $priority?></small></td>
                      <?php
                        echo "<td><span><a href=eventUpdate.php?id=".$id."><span class='fas fa-edit text-primary m-1'></span></a></span>  <span><a href=deleteEvent.php?id=".$id."><span class='fas fa-trash-alt text-danger m-1'></span></a></span> <span><a href=eventDone.php?id=".$id."><span class='fas fa-check-circle text-info m-1'></span></a></span></td>";
                      
                      ?>
                    </tr>
                  <?php
                }
              ?>
              
            </tbody>            
          </table>        
        </div>
      </div>
   </div>

   
<!-- Modal -->
<div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content rounded-1 border-0 py-3">
            <div class="modal-header border-0">
                <h4 class="mb-3 text-center"><a class="h3 text-primary text-capitalize text-center font-secondary" href="@@page-link">new event</a></h4>
                <button type="button" class="close btn-outline-primary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="col-3">
                    <div class="pt-3">
                      <h6 class="ml-2 h6 font-weight-bold text-capitalize">event type</h6>
                    </div>
                    <div class="pt-3 ">
                      <h6 class="ml-2 h6 font-weight-bold text-capitalize">event name</h6>
                    </div>
                    <div class="pt-4 ">
                      <h6 class="ml-2 h6 font-weight-bold text-capitalize">event venue</h6>
                    </div>
                    <div class="pt-3 ">
                      <h6 class="ml-2 h6 font-weight-bold text-capitalize">event date</h6>
                    </div>
                    <div class="pt-4 ">
                      <h6 class="ml-2 h6 font-weight-bold text-capitalize">event time</h6>
                    </div>
                    <div class="pt-3 ">
                      <h6 class="ml-2 h6 font-weight-bold text-capitalize">event priority</h6>
                    </div>
                    <div class="pt-4 ">
                      <h6 class="ml-2 h6 font-weight-bold text-capitalize">synopsis</h6>
                    </div>
                  </div>
                  <div class="col-8">
                    <form action="trial.php" method="POST" enctype="multipart/form-data">
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
                      <button type="submit" class="btn btn-primary btn-block mt-3 p-1" name="myEvents"style="height: 30px;">Save</button>
                    </form>
                  </div>
                  <div class="col-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<!-- today -->
<?php
  $today = date("y-m-d");
 
  $sqe_td = "SELECT * FROM todo_list WHERE event_date = '$today'";
    $opt_td = mysqli_query($conn, $sqe_td);
    $entries_td = mysqli_num_rows($opt_td);

?>

<div class="modal fade" id="today" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" >
        <div class="modal-content rounded-1 border-0 py-3">
            <div class="modal-header border-0">
                <h4 class="mb-3 text-center"><a class="h3 text-primary text-capitalize text-center font-secondary" href="@@page-link">today events</a></h4>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="container bg-muted rounded">
                <div class="pb-1 border-info" style="border-left: solid 1px; border-bottom: solid 1px; border-right: solid 1px;">
                  <div class="container-fluid bg-info p-2 mb-3">
                    <h6 class="text-uppercase text-white pl-2">today events <span class="ml-5 font-weight-lighter text-capitalize mt-2"><script>document.write(new Date());</script></span></h6>
                  </div>
                  <p class="mx-4">Shows <select class="pl-3" style="width: 60px; text-align: center;"><option value=""><?php echo $entries_td?></option></select> entries</p>
                  <p id="line" style="border-bottom: solid 2px; margin-bottom: 0px; margin-left: 23px; margin-right: 23px;"></p>

                  <div class="bg-light mx-4">
                    <table class="table table-hover table-bordered">
                      <thead style="height: 40px;">
                        <tr class="text-primary">
                          <th class="text-capitalize text-center" >view</th>
                          <th class="text-capitalize text-center" > name</th>
                          <th class="text-capitalize text-center" > venue</th>
                          <th class="text-capitalize text-center" > time</th>
                          <th class="text-capitalize text-center" >synopsis</th>
                          <th class="text-capitalize text-center" > priority</th>
                          <th class="text-capitalize text-center" >action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                          $today = date("y-m-d"); 
                          $sqe_td = "SELECT * FROM todo_list WHERE event_date = '$today'";
                          $opt_td = mysqli_query($conn, $sqe_td);

                          while($row_td = mysqli_fetch_assoc($opt_td)) {
                            $name = $row_td['event_name'];
                            $venue = $row_td['event_venue'];
                            $priority = $row_td['event_priority'];
                            $time = $row_td['event_time'];
                            $synopsis = $row_td['synopsis'];

                            ?>
                              <tr>
                                <td class="text-capitalize"><span class="fas fa-arrow-right ml-2 text-success"></span></td>
                                <td class="text-capitalize"><small><?php echo $name?></small></td>
                                <td class="text-capitalize"><small><?php echo $venue?></small></td>
                                <td class="text-capitalize"><small><?php echo $time?></small></td>
                                <td class="text-capitalize"><small><?php echo $synopsis?></small></td>
                                <td class="text-capitalize"><small><?php echo $priority?></small></td>
                                <?php
                                    echo "<td><span><a href=eventUpdate.php?id=".$id."><span class='fas fa-edit text-primary m-1'></span></a></span>  <span><a href=deleteEvent.php?id=".$id."><span class='fas fa-trash-alt text-danger m-1'></span></a></span> <span><a href=eventDone.php?id=".$id."><span class='fas fa-check-circle text-success m-1'></span></a></span></td>";
                                  
                                ?>
                              </tr>    
                            <?php
                          }
                        ?>
                        
                      </tbody>            
                    </table>        
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- /today -->

<!-- upcoming -->
<?php
  $today = date("y-m-d");
 
  $sqe_up = "SELECT * FROM todo_list WHERE event_date >= '$today'";
    $opt_up = mysqli_query($conn, $sqe_up);
    $entries_up = mysqli_num_rows($opt_up);

?>

<div class="modal fade" id="upcoming" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" >
        <div class="modal-content rounded-1 border-0 py-3">
            <div class="modal-header border-0">
                <h4 class="mb-3 text-center"><a class="h3 text-primary text-capitalize text-center font-secondary" href="@@page-link">upcoming events</a></h4>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="container bg-muted rounded">
                <div class="pb-1 border-info" style="border-left: solid 1px; border-bottom: solid 1px; border-right: solid 1px;">
                  <div class="container-fluid bg-info p-2 mb-3">
                    <h6 class="text-uppercase text-white pl-2">upcoming events <span class="ml-5 font-weight-lighter text-capitalize mt-2"><script>document.write(new Date());</script></span></h6>
                  </div>
                  <p class="mx-4">Shows <select class="pl-3" style="width: 60px; text-align: center;"><option value=""><?php echo $entries_up?></option></select> entries</p>
                  <p id="line" style="border-bottom: solid 2px; margin-bottom: 0px; margin-left: 23px; margin-right: 23px;"></p>

                  <div class="bg-light mx-4">
                    <table class="table table-hover table-bordered">
                      <thead style="height: 40px;">
                        <tr class="text-primary">
                          <th class="text-capitalize text-center" >view</th>
                          <th class="text-capitalize text-center" > name</th>
                          <th class="text-capitalize text-center" > venue</th>
                          <th class="text-capitalize text-center" > date</th>
                          <th class="text-capitalize text-center" > time</th>
                          <th class="text-capitalize text-center" >synopsis</th>
                          <th class="text-capitalize text-center" > priority</th>
                          <th class="text-capitalize text-center" >action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                          $today = date("y-m-d"); 
                          $sqe_up = "SELECT * FROM todo_list WHERE event_date >= '$today'";
                          $opt_up = mysqli_query($conn, $sqe_up);

                          while($row_up = mysqli_fetch_assoc($opt_up)) {
                            $name = $row_up['event_name'];
                            $venue = $row_up['event_venue'];
                            $priority = $row_up['event_priority'];
                            $time = $row_up['event_time'];
                            $date = $row_up['event_date'];
                            $synopsis = $row_up['synopsis'];

                            ?>
                              <tr>
                                <td class="text-capitalize"><span class="fas fa-arrow-right ml-2 text-success"></span></td>
                                <td class="text-capitalize"><small><?php echo $name?></small></td>
                                <td class="text-capitalize"><small><?php echo $venue?></small></td>
                                <td class="text-capitalize"><small><?php echo $date?></small></td>
                                <td class="text-capitalize"><small><?php echo $time?></small></td>
                                <td class="text-capitalize"><small><?php echo $synopsis?></small></td>
                                <td class="text-capitalize"><small><?php echo $priority?></small></td>
                                <?php
                                    echo "<td><span><a href=eventUpdate.php?id=".$id."><span class='fas fa-edit text-primary m-1'></span></a></span>  <span><a href=deleteEvent.php?id=".$id."><span class='fas fa-trash-alt text-danger m-1'></span></a></span> <span><a href=eventDone.php?id=".$id."><span class='fas fa-check-circle text-success m-1'></span></a></span></td>";
                                  
                                ?>
                              </tr>
                            <?php
                          }
                        ?>
                        
                      </tbody>            
                    </table>        
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- /upcoming -->


<!-- high -->
<?php
      $sqe_h = "SELECT * FROM todo_list WHERE event_priority = 'high'";
      $opt_h = mysqli_query($conn, $sqe_h);

      $entries_h = mysqli_num_rows($opt_h);
    ?>
<div class="modal fade" id="high" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" >
        <div class="modal-content rounded-1 border-0 py-3">
            <div class="modal-header border-0">
                <h4 class="mb-3 text-center"><a class="h3 text-primary text-capitalize text-center font-secondary" href="@@page-link">high priority events</a></h4>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="container bg-muted rounded">
                <div class="pb-1 border-info" style="border-left: solid 1px; border-bottom: solid 1px; border-right: solid 1px;">
                  <div class="container-fluid bg-info p-2 mb-3">
                    <h6 class="text-uppercase text-white pl-2">high priority <span class="ml-5 font-weight-lighter text-capitalize mt-2"><script>document.write(new Date());</script></span></h6>
                  </div>
                  <p class="mx-4">Shows <select class="pl-3" style="width: 60px; text-align: center;"><option value=""><?php echo $entries_h?></option></select> entries</p>
                  <p id="line" style="border-bottom: solid 2px; margin-bottom: 0px; margin-left: 23px; margin-right: 23px;"></p>

                  <div class="bg-light mx-4">
                    <table class="table table-hover table-bordered">
                      <thead style="height: 40px;">
                        <tr class="text-primary">
                          <th class="text-capitalize text-center" >view</th>
                          <th class="text-capitalize text-center" > name</th>
                          <th class="text-capitalize text-center" > venue</th>
                          <th class="text-capitalize text-center" > date</th>
                          <th class="text-capitalize text-center" > time</th>
                          <th class="text-capitalize text-center" >synopsis</th>
                          <th class="text-capitalize text-center" >action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $ql_f = "SELECT * FROM todo_list WHERE event_priority = 'high'";
                          $results_f = mysqli_query($conn, $ql_f);

                          while($row_f = mysqli_fetch_assoc($results_f)) {
                            $name = $row_f['event_name'];
                            $venue = $row_f['event_venue'];
                            $date = $row_f['event_date'];
                            $time = $row_f['event_time'];
                            $synopsis = $row_f['synopsis'];

                            ?>
                              <tr>
                                <td class="text-capitalize"><span class="fas fa-arrow-right ml-2 text-success"></span></td>
                                <td class="text-capitalize"><small><?php echo $name?></small></td>
                                <td class="text-capitalize"><small><?php echo $venue?></small></td>
                                <td class="text-capitalize"><small><?php echo $date?></small></td>
                                <td class="text-capitalize"><small><?php echo $time?></small></td>
                                <td class="text-capitalize"><small><?php echo $synopsis?></small></td>
                                <?php
                                    echo "<td><span><a href=eventUpdate.php?id=".$id."><span class='fas fa-edit text-primary m-1'></span></a></span>  <span><a href=deleteEvent.php?id=".$id."><span class='fas fa-trash-alt text-danger m-1'></span></a></span> <span><a href=eventDone.php?id=".$id."><span class='fas fa-check-circle text-success m-1'></span></a></span></td>";
                                  
                                ?>
                              </tr>
                            <?php
                          }
                        ?>
                        
                      </tbody>            
                    </table>        
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- high --> 

<!-- low -->
<?php
      $sqe_h = "SELECT * FROM todo_list WHERE event_priority = 'low'";
      $opt_h = mysqli_query($conn, $sqe_h);

      $entries_h = mysqli_num_rows($opt_h);
    ?>
<div class="modal fade" id="low" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" >
        <div class="modal-content rounded-1 border-0 py-3">
            <div class="modal-header border-0">
                <h4 class="mb-3 text-center"><a class="h3 text-primary text-capitalize text-center font-secondary" href="@@page-link">low priority events</a></h4>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="container bg-muted rounded">
                <div class="pb-1 border-info" style="border-left: solid 1px; border-bottom: solid 1px; border-right: solid 1px;">
                  <div class="container-fluid bg-info p-2 mb-3">
                    <h6 class="text-uppercase text-white pl-2">low priority <span class="ml-5 font-weight-lighter text-capitalize mt-2"><script>document.write(new Date());</script></span></h6>
                  </div>
                  <p class="mx-4">Shows <select class="pl-3" style="width: 60px; text-align: center;"><option value=""><?php echo $entries_h?></option></select> entries</p>
                  <p id="line" style="border-bottom: solid 2px; margin-bottom: 0px; margin-left: 23px; margin-right: 23px;"></p>

                  <div class="bg-light mx-4">
                    <table class="table table-hover table-bordered">
                      <thead style="height: 40px;">
                        <tr class="text-primary">
                          <th class="text-capitalize text-center" >view</th>
                          <th class="text-capitalize text-center" > name</th>
                          <th class="text-capitalize text-center" > venue</th>
                          <th class="text-capitalize text-center" > date</th>
                          <th class="text-capitalize text-center" > time</th>
                          <th class="text-capitalize text-center" >synopsis</th>
                          <th class="text-capitalize text-center" >action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $ql_f = "SELECT * FROM todo_list WHERE event_priority = 'low'";
                          $results_f = mysqli_query($conn, $ql_f);

                          while($row_f = mysqli_fetch_assoc($results_f)) {
                            $name = $row_f['event_name'];
                            $venue = $row_f['event_venue'];
                            $date = $row_f['event_date'];
                            $time = $row_f['event_time'];
                            $synopsis = $row_f['synopsis'];

                            ?>
                              <tr>
                                <td class="text-capitalize"><span class="fas fa-arrow-right ml-2 text-success"></span></td>
                                <td class="text-capitalize"><small><?php echo $name?></small></td>
                                <td class="text-capitalize"><small><?php echo $venue?></small></td>
                                <td class="text-capitalize"><small><?php echo $date?></small></td>
                                <td class="text-capitalize"><small><?php echo $time?></small></td>
                                <td class="text-capitalize"><small><?php echo $synopsis?></small></td>
                                <?php
                                    echo "<td><span><a href=eventUpdate.php?id=".$id."><span class='fas fa-edit text-primary m-1'></span></a></span>  <span><a href=deleteEvent.php?id=".$id."><span class='fas fa-trash-alt text-danger m-1'></span></a></span> <span><a href=eventDone.php?id=".$id."><span class='fas fa-check-circle text-success m-1'></span></a></span></td>";
                                  
                                ?>
                              </tr>
                            <?php
                          }
                        ?>
                        
                      </tbody>            
                    </table>        
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- low --> 

<!-- medium -->
<?php
      $sqe_h = "SELECT * FROM todo_list WHERE event_priority = 'medium'";
      $opt_h = mysqli_query($conn, $sqe_h);

      $entries_h = mysqli_num_rows($opt_h);
    ?>
<div class="modal fade" id="medium" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" >
        <div class="modal-content rounded-1 border-0 py-3">
            <div class="modal-header border-0">
                <h4 class="mb-3 text-center"><a class="h3 text-primary text-capitalize text-center font-secondary" href="@@page-link">medium priority events</a></h4>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="container bg-muted rounded">
                <div class="pb-1 border-info" style="border-left: solid 1px; border-bottom: solid 1px; border-right: solid 1px;">
                  <div class="container-fluid bg-info p-2 mb-3">
                    <h6 class="text-uppercase text-white pl-2">medium priority <span class="ml-5 font-weight-lighter text-capitalize mt-2"><script>document.write(new Date());</script></span></h6>
                  </div>
                  <p class="mx-4">Shows <select class="pl-3" style="width: 60px; text-align: center;"><option value=""><?php echo $entries_h?></option></select> entries</p>
                  <p id="line" style="border-bottom: solid 2px; margin-bottom: 0px; margin-left: 23px; margin-right: 23px;"></p>

                  <div class="bg-light mx-4">
                    <table class="table table-hover table-bordered">
                      <thead style="height: 40px;">
                        <tr class="text-primary">
                          <th class="text-capitalize text-center" >view</th>
                          <th class="text-capitalize text-center" > name</th>
                          <th class="text-capitalize text-center" > venue</th>
                          <th class="text-capitalize text-center" > date</th>
                          <th class="text-capitalize text-center" > time</th>
                          <th class="text-capitalize text-center" >synopsis</th>
                          <th class="text-capitalize text-center" >action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $ql_f = "SELECT * FROM todo_list WHERE event_priority = 'medium'";
                          $results_f = mysqli_query($conn, $ql_f);

                          while($row_f = mysqli_fetch_assoc($results_f)) {
                            $name = $row_f['event_name'];
                            $venue = $row_f['event_venue'];
                            $date = $row_f['event_date'];
                            $time = $row_f['event_time'];
                            $synopsis = $row_f['synopsis'];

                            ?>
                              <tr>
                                <td class="text-capitalize"><span class="fas fa-arrow-right ml-2 text-success"></span></td>
                                <td class="text-capitalize"><small><?php echo $name?></small></td>
                                <td class="text-capitalize"><small><?php echo $venue?></small></td>
                                <td class="text-capitalize"><small><?php echo $date?></small></td>
                                <td class="text-capitalize"><small><?php echo $time?></small></td>
                                <td class="text-capitalize"><small><?php echo $synopsis?></small></td>
                                <?php
                                    echo "<td><span><a href=eventUpdate.php?id=".$id."><span class='fas fa-edit text-primary m-1'></span></a></span>  <span><a href=deleteEvent.php?id=".$id."><span class='fas fa-trash-alt text-danger m-1'></span></a></span> <span><a href=eventDone.php?id=".$id."><span class='fas fa-check-circle text-success m-1'></span></a></span></td>";
                                  
                                ?>
                              </tr>
                            <?php
                          }
                        ?>
                        
                      </tbody>            
                    </table>        
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- medium --> 

<!-- done -->
<?php
      $sqe_h = "SELECT * FROM todo_list WHERE status = 1";
      $opt_h = mysqli_query($conn, $sqe_h);

      $entries_h = mysqli_num_rows($opt_h);
    ?>
<div class="modal fade" id="done" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" >
        <div class="modal-content rounded-1 border-0 py-3">
            <div class="modal-header border-0">
                <h4 class="mb-3 text-center"><a class="h3 text-primary text-capitalize text-center font-secondary" href="@@page-link">done events</a></h4>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="container bg-muted rounded">
                <div class="pb-1 border-info" style="border-left: solid 1px; border-bottom: solid 1px; border-right: solid 1px;">
                  <div class="container-fluid bg-info p-2 mb-3">
                    <h6 class="text-uppercase text-white pl-2">done <span class="ml-5 font-weight-lighter text-capitalize mt-2"><script>document.write(new Date());</script></span></h6>
                  </div>
                  <p class="mx-4">Shows <select class="pl-3" style="width: 60px; text-align: center;"><option value=""><?php echo $entries_h?></option></select> entries</p>
                  <p id="line" style="border-bottom: solid 2px; margin-bottom: 0px; margin-left: 23px; margin-right: 23px;"></p>

                  <div class="bg-light mx-4">
                    <table class="table table-hover table-bordered">
                      <thead style="height: 40px;">
                        <tr class="text-primary">
                          <th class="text-capitalize text-center" >view</th>
                          <th class="text-capitalize text-center" > name</th>
                          <th class="text-capitalize text-center" > venue</th>
                          <th class="text-capitalize text-center" > date</th>
                          <th class="text-capitalize text-center" > time</th>
                          <th class="text-capitalize text-center" >synopsis</th>
                          <th class="text-capitalize text-center" >action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $ql_f = "SELECT * FROM todo_list WHERE status = 1";
                          $results_f = mysqli_query($conn, $ql_f);

                          while($row_f = mysqli_fetch_assoc($results_f)) {
                            $name = $row_f['event_name'];
                            $venue = $row_f['event_venue'];
                            $date = $row_f['event_date'];
                            $time = $row_f['event_time'];
                            $synopsis = $row_f['synopsis'];

                            ?>
                              <tr>
                                <td class="text-capitalize"><span class="fas fa-arrow-right ml-2 text-success"></span></td>
                                <td class="text-capitalize"><small><?php echo $name?></small></td>
                                <td class="text-capitalize"><small><?php echo $venue?></small></td>
                                <td class="text-capitalize"><small><?php echo $date?></small></td>
                                <td class="text-capitalize"><small><?php echo $time?></small></td>
                                <td class="text-capitalize"><small><?php echo $synopsis?></small></td>
                                <?php
                                    echo "<td><span><a href=eventUpdate.php?id=".$id."><span class='fas fa-edit text-primary m-1'></span></a></span>  <span><a href=deleteEvent.php?id=".$id."><span class='fas fa-trash-alt text-danger m-1'></span></a></span> <span><a href=event_notDone.php?id=".$id."><span class='fas fa-times-circle text-info m-1'></span></a></span></td>";
                                  
                                ?>
                              </tr>
                            <?php
                          }
                        ?>
                        
                      </tbody>            
                    </table>        
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- done --> 

<!-- not-done -->
<?php
      $sqe_h = "SELECT * FROM todo_list WHERE status = 1";
      $opt_h = mysqli_query($conn, $sqe_h);

      $entries_h = mysqli_num_rows($opt_h);
    ?>
<div class="modal fade" id="notDone" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" >
        <div class="modal-content rounded-1 border-0 py-3">
            <div class="modal-header border-0">
                <h4 class="mb-3 text-center"><a class="h3 text-primary text-capitalize text-center font-secondary" href="@@page-link">events not done</a></h4>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="container bg-muted rounded">
                <div class="pb-1 border-info" style="border-left: solid 1px; border-bottom: solid 1px; border-right: solid 1px;">
                  <div class="container-fluid bg-info p-2 mb-3">
                    <h6 class="text-uppercase text-white pl-2">events not done <span class="ml-5 font-weight-lighter text-capitalize mt-2"><script>document.write(new Date());</script></span></h6>
                  </div>
                  <p class="mx-4">Shows <select class="pl-3" style="width: 60px; text-align: center;"><option value=""><?php echo $entries_h?></option></select> entries</p>
                  <p id="line" style="border-bottom: solid 2px; margin-bottom: 0px; margin-left: 23px; margin-right: 23px;"></p>

                  <div class="bg-light mx-4">
                    <table class="table table-hover table-bordered">
                      <thead style="height: 40px;">
                        <tr class="text-primary">
                          <th class="text-capitalize text-center" >view</th>
                          <th class="text-capitalize text-center" > name</th>
                          <th class="text-capitalize text-center" > venue</th>
                          <th class="text-capitalize text-center" > date</th>
                          <th class="text-capitalize text-center" > time</th>
                          <th class="text-capitalize text-center" >synopsis</th>
                          <th class="text-capitalize text-center" >action</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                          
                            $ql_f = "SELECT * FROM todo_list WHERE status = 0";
                            $results_f = mysqli_query($conn, $ql_f);
            
                            while($row_f = mysqli_fetch_assoc($results_f)) {
                              $id = $row_f['id'];
                              $name = $row_f['event_name'];
                              $venue = $row_f['event_venue'];
                              $date = $row_f['event_date'];
                              $time = $row_f['event_time'];
                              $priority = $row_f['event_priority'];
                              $synopsis = $row_f['synopsis'];
                              ?>
                                <tr>
                                  <td class="text-capitalize"><span class="fas fa-arrow-right ml-2 text-success"></span></td>
                                  <td class="text-capitalize"><small><?php echo $name?></small></td>
                                  <td class="text-capitalize"><small><?php echo $venue?></small></td>
                                  <td class="text-capitalize"><small><?php echo $date?></small></td>
                                  <td class="text-capitalize"><small><?php echo $time?></small></td>
                                  <td class="text-capitalize"><small><?php echo $synopsis?></small></td>
                                  <td class="text-capitalize"><small><?php echo $priority?></small></td>
                                  <?php
                                    echo "<td><span><a href=eventUpdate.php?id=".$id."><span class='fas fa-edit text-primary m-1'></span></a></span>  <span><a href=deleteEvent.php?id=".$id."><span class='fas fa-trash-alt text-danger m-1'></span></a></span> <span><a href=eventDone.php?id=".$id."><span class='fas fa-check-circle text-success m-1'></span></a></span></td>";
                                  
                                  ?>
                                </tr>
                              <?php
                            }
                          ?>
                          
                        </tbody>            
                    </table>        
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- nor-done --> 
  <!-- footer -->
  <div class="container-fluid bg-info mt-5 py-3">
    <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h5 class="font-italic text-light">Event type</h5>
          <ul style="list-style: none; font-size: 14px; text-decoration: italics;">
              <li><span class="fas fa-angle-right"></span> Work events</li>
              <li><span class="fas fa-angle-right"></span> Family events</li>
              <li><span class="fas fa-angle-right"></span> Friends</li>
              <li><span class="fas fa-angle-right"></span> Religion events</li>
              <li><span class="fas fa-angle-right"></span> Academic events</li>
          </ul>
      </div>
      <div class="col-md-3">
        <h5 class="font-italic text-light">Event priorities</h5>
        <ul style="list-style: none; font-size: 14px;">
            <li><span class="fas fa-angle-right text-danger"></span> high priority</li>
            <li><span class="fas fa-angle-right text-warning"></span> Medium priority</li>
            <li> <a  href="#" data-toggle="modal" data-target="#low" class="text-capitalize text-dark"><span class="fas fa-angle-right"></span> low priority</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5 class="font-italic text-light">Attended events</h5>
          <ul style="list-style: none; font-size: 14px;">
              <li><span class="fas fa-angle-right text-danger"></span> medium priority</li>
              <li><span class="fas fa-angle-right text-warning"></span> Medium priority</li>
              <li><span class="fas fa-angle-right"></span> medium priority</li>
          </ul>
        </div>   
      <div class="col-md-3">
        <h5 class=" font-italic text-light">Attended events</h5>
          <ul style="list-style: none; font-size: 14px;">
              <li><span class="fas fa-angle-right text-danger"></span> medium priority</li>
              <li><span class="fas fa-angle-right text-warning"></span> Medium priority</li>
              <li><span class="fas fa-angle-right"></span> medium priority</li>
          </ul>
      </div> 
    </div>
    <hr class='text-white'>
    <h6 class="text-center font-weight-lighter text-light mb-0 mt2">&copy Cyrus (Mwalimu)</h6>
  </div>
  </body>
</html>

    
    <!--jquery-->
    <script src="./js/jquery-3.4.1.min.js"></script>
    <!--bootsrap js-->
    <script src="./js/bootstrap.bundle.min.js"></script>

</body>
</html>