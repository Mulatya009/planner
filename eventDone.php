<?php
    session_start();

    $email = $_SESSION['user'];  
  
    if(!isset($_SESSION['user'])){
      header('location:index.php');
    }
    
    if(isset($_GET['id'])){
        $_SESSION['id']=$_GET['id'];

        ?>
        <script>
            var x=window.onbeforeunload;
            // logic to make the confirm and alert boxes
            if (confirm("Confirm that the event has been done?") == true) { 
                window.location.href = "done.php";
            }
            else{
            window.location.href = "trial.php";
            }
        </script>
        <?php
    } else{
         header('location:index.php');        
    }

?>
