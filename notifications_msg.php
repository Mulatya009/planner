<?php
    // variables
    $email = "cyrus";
    $passw = "one";

    if(isset($_POST['submit'])) {
        $e = $_POST['email'];
        $p = $_POST['pass'];

        $e_error = "";
        $p_error = "";

        if(empty($e_error)){            
            $e_error = "please enter email";
        }
        else if($email != $e) {
            $e_error = "That email does not exist";
        }

        else if($passw != $p) {
            $p_error = " Wrong Password";
        }
        else{
            $p_error = "Login successiful";
        }
    }
    // test wether all variables are working
    // echo $email;
    // echo $passw;
    // echo $e;
    // echo $p;

   


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
    <link rel="stylesheet" href="css/main.css">

</head>
<body>

<div class="container text-center mt-5 p-5 card">
    <form action="notifications_msg.php" method="POST">
        <input type="text" class= "form-control mt-5" name="email" placeholder="Email">
        <p class="text-left text-danger "><?php  echo $e_error; ?></p>
        <input type="text" class= "form-control mt-3" name="pass" placeholder="Password">
        <p class="text-left text-danger "><?php  echo $p_error; ?></p>
        <input type="submit" class= "border-2 btn btn-outline-primary btn-block mt-3" name="submit">
    </form>

</div>

<?php
    // $today = date("d-m-yy");


    // echo $date;
    // echo $today;
?>


    
    <!--jquery-->
    <script src="./js/jquery-3.4.1.min.js"></script>
    <!--bootsrap js-->
    <script src="./js/bootstrap.bundle.min.js"></script>
    
</body>
</html>