<?php
$id= $_GET['id'];

include('conn.php');

$sql = mysqli_query($conn, "UPDATE todo_list SET status= 1 WHERE id = '$id' ");

if($sql){
    header('location:trial.php?success=1');
}

?>