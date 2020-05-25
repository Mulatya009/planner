<?php
    session_start();
    $id = $_SESSION['id'];

    include('conn.php');
    $d_sql = mysqli_query($conn, "DELETE FROM todo_list WHERE id = '$id'");

    if(!$d_sql){
        exit('error when deleting the event');
    } else {
        ?> 
        <script>
            var x=window.onbeforeunload;
            // logic to make the confirm and alert boxes
            if (confirm("Event deleted successifuly") == true) { 
                window.location.href = "trial.php";
            }
            else{
            window.location.href = "trial.php";
            }
        </script>
        <?php
    }
?>