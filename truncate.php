<?php 
    session_start();
    include ("connection.php");
    if(isset($_SESSION['id']) && $_SESSION['id']=='admin'){
        $sql="TRUNCATE TABLE specialdutyroster;";
                if (mysqli_query($con, $sql)) {
                    $msg1 ='Successfully Updated!';
                    echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                } else {
                    $msg2 ='Error in Updating!';
                    echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                }
    }else{
        $msg ='Unauthorized Access Attempt!';
        echo "<script>alert('$msg'); location.href='index.php'</script>";
    }
?>