<?php
    //database connection
    include('conn.php');
    
    //message varriable;
    $success = '';
    
    //register;
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

                if(empty($userEmail)){
                    $success = "Please! Email is required";
                }
                elseif(empty($userPassword)){
                    $success = "Please! Password is required";
                }
                elseif($userEmail != $e){
                    $success = "The User does not Exist";
                }else{
                    if($userEmail === $e AND $userPassword === $p) {
                        $_SESSION['user'] = $e;
                        header('location: trial.php');
                    }
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
    <link rel="stylesheet" href="css/main.css">

</head>
<style>
  
#form{
    margin-top: 170px;
}
a:hover{
    text-decoration: none;
  }
</style>
<body>
    <!-- login tablet -->
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card mb" id="form">
                    <form class="mx-5 my-2" action="index.php" method = "POST"> 
                        <h4 class="text-center font-weight-bolder text-info my-3">Sign In</h4>
                        <p class="font-weight-lighter text-white text-center bg-danger rounded"><span><?php if(!empty($success)) { echo $success; } ?></span></p>
                        <input type="email" class="form-control mb-1 rounded-3 text-muted border-primary" id="loginName" name="email" placeholder="Email*" style="height: 50px;">
                        <input type="password" class="form-control mb-2 rounded-3 text-muted border-primary" id="loginPassword" name="loginPassword" placeholder="Password*" style="height: 50px;">
                        <button type="submit" class="btn btn-primary btn-block p-1" style="height: 30px;" name="login"><span class="font-weight-bold">Login</span></button>                  
                    </form>
                    <div class="row">
                        <div class="col-6">
                            <p class="text-right mr-5" style="font-family: arial; font-size: 15px;"><span>Not registered? <a href="#" data-toggle="modal" data-target="#register">Register</a></span> </p>
                        </div>
                        <div class="col-6">
                            <p class="text-right mr-5" style="font-family: arial; font-size: 15px;"><span>Forgot password? <a href="#" data-toggle="modal" data-target="#reset">Reset</a></<span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

<!--register Modal -->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content rounded-1 border-0 py-2">
            <div class="modal-header border-0">
                <h4 class="mb-1 text-center"><a class="h4 text-primary text-capitalize font-weight-bolder" href="@@page-link">register</a></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3">
                        <div class="pt-3 ">
                        <h6 class="ml-2 text-capitalize">passport</h6>
                        </div> 
                        <div class="pt-4">
                        <h6 class="ml-2 text-capitalize">user name</h6>
                        </div>
                        <div class="pt-3">
                        <h6 class="ml-2 text-capitalize">first name</h6>
                        </div>
                        <div class="pt-4 ">
                        <h6 class="ml-2 text-capitalize">last name</h6>
                        </div>
                        <div class="pt-4 ">
                        <h6 class="ml-2 text-capitalize">email</h6>
                        </div>
                        <div class="pt-3 ">
                        <h6 class="ml-2 text-capitalize">password</h6>
                        </div>
                        <div class="pt-3 ">
                        <h6 class="ml-2 text-capitalize">confirm password</h6>
                        </div>
                        <div class="pt-4 ">
                        <h6 class="ml-2 text-capitalize">security question</h6>
                        </div>
                    </div>
                    <div class="col-8">
                        <form action="index.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="upload" style="height: 40px;" class="mt-2  file-upload-info" required>
                            <input type="text" name="username" style="height: 40px;" class="mt-2 form-control" required>
                            <input type="text" name="firstname" style="height: 40px;" class="mt-2 form-control" required>
                            <input type="text" name="lastname" style="height: 40px;" class="mt-2 form-control" required>     
                            <input type="email" name="email" style="height: 40px;" class="mt-2 form-control"  required>
                            <input type="password" name="password" style="height: 40px;" class="mt-2 form-control" required>
                            <input type="password" name="cpassword" style="height: 40px;" class="mt-2 form-control" required>
                            <div class="row">
                                <div class="col-6">
                                    <select name="question" id="" class="form-control mt-2">
                                        <option value="Work">What is your name?</option>
                                        <option value="Fun">Which month were you born?</option>
                                        <option value="Academic">Where were you born?</option>
                                        <option value="Leisure">Which town do you come from?</option>
                                        <option value="Family">Which is your favorite dish?</option>
                                        <option value="Friends">Which school did you first enrol?</option>
                                        <option value="Religion">What is your name?</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="answer" style="height: 40px;" class="mt-2 form-control" required placeholder="Answer">     
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-2 p-1" name="reg"style="height: 30px;">Register</button>
                        </form>
                    </div>
                    <div class="col-1"></div>
                    </div>
            </div>
        </div>
    </div>
</div>
<!--register Modal -->

<!-- reset modal -->
<div class="modal fade" id="reset" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content rounded-1 border-0 py-2">
            <div class="modal-header border-0">
                <h4 class="mb-1 text-center"><a class="h4 text-primary text-capitalize font-weight-bolder" href="@@page-link">reset password</a></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button class="btn btn-outline-info border-0 " id="help-btn">Reset help</button>
                <div class="mr-5 my-3 text-muted" id="help-message"></div>
                <div class="row">
                    <div class="col-3">
                        <div class="pt-4">
                        <h6 class="ml-2 text-capitalize">user name</h6>
                        </div>
                        <div class="pt-4 ">
                        <h6 class="ml-2 text-capitalize">email</h6>
                        </div>
                        <div class="pt-3 ">
                        <h6 class="ml-2 text-capitalize">security question</h6>
                        </div>
                        <div class="pt-3 ">
                        <h6 class="ml-2 text-capitalize">new password</h6>
                        </div>
                        <div class="pt-4 ">
                        <h6 class="ml-2 text-capitalize">confirm password</h6>
                        </div>
                    </div>
                    <div class="col-8">
                        <form action="index.php" method="POST" enctype="multipart/form-data">
                            <input type="text" name="username_r" style="height: 40px;" class="mt-2 form-control">
                            <input type="email" name="email_r" style="height: 40px;" class="mt-2 form-control">
                            <div class="row">
                                <div class="col-6">
                                    <select name="question" id="" class="form-control mt-2">
                                        <option value="Work">What is your name?</option>
                                        <option value="Fun">Which month were you born?</option>
                                        <option value="Academic">Where were you born?</option>
                                        <option value="Leisure">Which town do you come from?</option>
                                        <option value="Family">Which is your favorite dish?</option>
                                        <option value="Friends">Which school did you first enrol?</option>
                                        <option value="Religion">What is your name?</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="answer" style="height: 40px;" class="mt-2 form-control" required placeholder="Answer">     
                                </div>
                            </div>
                            <input type="password" name="password_r" style="height: 40px;" class="mt-2 form-control" required>
                            <input type="password" name="cpassword_r" style="height: 40px;" class="mt-2 form-control" required>
                            <button type="submit" class="btn btn-primary btn-block mt-2 p-1" name="reset"style="height: 30px;">Reset</button>
                        </form>
                    </div>
                    <div class="col-1"></div>
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- /reset modal -->

    
   
    <!-- app.js -->
    <script src="app.js"></script>
    <!--jquery-->
    <script src="./js/jquery-3.4.1.min.js"></script>
    <!--bootsrap js-->
    <script src="./js/bootstrap.bundle.min.js"></script>

</body>
</html>