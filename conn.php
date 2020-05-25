<?php
     //database connection
    $conn = mysqli_connect('localhost', 'cycaminf_user', 'newMc50384346', 'cycaminf_dbtrial');

    //test connection
    if($conn) {
        //print('connected');
    }else{
        exit('connection failed');
    }

    //database selection
    $db_select = mysqli_select_db($conn, 'cycaminf_dbtrial');

    //test selection
    if(!$db_select) {
        die('db not selected');
    }else{
        //echo('selected');
    }

?>