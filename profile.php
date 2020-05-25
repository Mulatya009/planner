<?php
    //database connection
    $conn = mysqli_connect('localhost', 'root', '', 'dbtrial');

    //test connection
    if($conn) {
        //print('connected');
    }else{
        exit('connection failed');
    }

    //database selection
    $db_select = mysqli_select_db($conn, 'dbtrial');

    //test selection
    if(!$db_select) {
        die('db not selected');
    }else{
        //echo('selected');
    }

    //when the btn is clicked
    if(isset($_POST['reg'])) {
        $userName = trim(mysqli_real_escape_string($conn, $_POST['username']));
        $firstName = trim(mysqli_real_escape_string($conn, $_POST['firstname']));
        $lastName = trim(mysqli_real_escape_string($conn, $_POST['lastname']));
        $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
        $password = trim(mysqli_real_escape_string($conn, $_POST['password']));
        $cpassword = trim( mysqli_real_escape_string($conn, $_POST['cpassword']));
        $answer = trim(mysqli_real_escape_string($conn, $_POST['answer']));

        //image upload
        $name = $_FILES['upload'] ['name'];
        $size = $_FILES['upload'] ['size'];
        $type = $_FILES['upload'] ['type'];
        $temp = $_FILES['upload'] ['tmp_name'];

        //move uploaded file
        move_uploaded_file($temp, "img/" .$name);
        
        //check wether the user is already registered
        $sql = "SELECT * FROM uses";

        $results = mysqli_query($conn, $sql);
        
        while($fetch = mysqli_fetch_assoc($results)) {
            $dp = $fetch['img'];
            $user = $fetch['user_name'];
            $fName = $fetch['first_name'];
            $lName = $fetch['last_name'];
            $db_password = $fetch['password'];
            $mail = $fetch['email'];            
        }
        
        if($email === $mail) {
            die('user already exist');
            
        }
        else if($password !== $cpassword) {
            die('passwords do not match');
            header:location('index.php');
        }
       
        else{
            $add_sql = "INSERT INTO uses (img, user_name, first_name, last_name, email, password, security_answer) VALUES ('$name', '$userName', '$firstName', '$lastName', '$email', '$password', '$answer')";
            $option = mysqli_query($conn, $add_sql);

            if(!$option) {
                exit('user not registered successifully');
            }
            else{
                echo('user added successifully');
            }
        }      
 
    }
    //login
    if(isset($_POST['login'])) {

        session_start();

            $userEmail = trim(mysqli_real_escape_string($conn, $_POST['email']));
            $userPassword = trim(mysqli_real_escape_string($conn, $_POST['loginPassword']));

            $sql = " SELECT * FROM uses";
            $option = mysqli_query($conn, $sql);
            
            while($row = mysqli_fetch_assoc($option)) {
                $e = $row['email'];
                $p = $row['password'];

                if($userEmail === $e AND $userPassword === $p) {
                    $_SESSION['user'] = $e;

                    ?>
                    <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> You have been signed in successfully!
                    </div>

                    <script>
                        window.setTimeout(function() {
                        $(".alert").fadeTo(500, 0).fadeIn(500, function(){
                            $(this).remove(); 
                        });
                    }, 4000);
                    </script>
                    <?php

                    header('location: trial.php');
                }
            }
  
    }

    //reset password
    if(isset($_POST['reset'])) {
        $userName_r = trim(mysqli_real_escape_string($conn, $_POST['username_r']));
        $email_r = trim(mysqli_real_escape_string($conn, $_POST['email_r']));
        $password_r = trim(mysqli_real_escape_string($conn, $_POST['password_r']));
        $cpassword_r = trim( mysqli_real_escape_string($conn, $_POST['cpassword_r']));
        $answer_r = trim(mysqli_real_escape_string($conn, $_POST['answer']));
       
        // fetch user details
        $sql_r = "SELECT * FROM uses";
        $results_r = mysqli_query($conn, $sql_r);
        
        while($fetch = mysqli_fetch_assoc($results_r)) {
            $user_r = $fetch['user_name'];
            $mail_r = $fetch['email'];
            $ans_r = $fetch['security_answer'];
            $dbPass_r = $fetch['password'];
        }

        if($password_r != $cpassword_r){
            die('The passwords do not match!!!');
        }
        elseif($password_r  === $dbPass_r){
            exit('this is the current password');
        }
        elseif($userName_r === $user_r || $email_r === $mail_r){
            if($answer_r === $ans_r){
                $sq_r = mysqli_query($conn, "UPDATE uses SET password = '$password_r' WHERE email = '$mail_r'");
                if(!$sq_r){
                    die('reset unsuccessiful');
                } else{
                    print('your password reset was successiful. your password your secret ');
                }
            }
        }else{
            echo('Please enter the correct User Name or Email');
        }  
 
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
    <!-- <link rel="stylesheet" href="css/main.css"> -->

</head>
<style>

a:hover{
    text-decoration: none;
  }
</style>
<body>
    <div class="content-wrapper">
        <!-- page title -->
        <section class="page-title-section overlay bg-info py-4" data-background="images/backgrounds/page-title.jpg">
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
        
        <!-- updatte profile -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-center"><i class="fa fa-user"></i> Profile</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="container mt-4">
                                        <span class="text-capitalize font-weight-bolder"> mulatya cyrus</span>
                                        <span class="mt-1"><small >mulatyacyrus@gmail.com</small></span>
                                        <h6><small><em class="font-weight-light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor, nam.</em></small></h6>
                                    </div>
                                </div>
                                <div class="col-md-4 bg-secondary p-5">
                                    <h5>pic</h5>
                                </div>
                            </div>
                            <div class="container mt-2">
                                <h6 class="font-family-arial ml-5">Update profile</h6>
                                <form action="">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="placeholder">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="placeholder">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="placeholder">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" class="form-control" placeholder="placeholder">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" placeholder="placeholder">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info">UPDATE</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <!-- app.js -->
    <script src="app.js"></script>
    <!--jquery-->
    <script src="./js/jquery-3.4.1.min.js"></script>
    <!--bootsrap js-->
    <script src="./js/bootstrap.bundle.min.js"></script>

</body>
</html>