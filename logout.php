<?php 
    session_start();
    $msg ='Logging Out!';
    echo "<script>alert('$msg'); location.href='index.php'</script>";
    include('connection.php');
    $ssID=$_SESSION['id'];
    $sql="DELETE FROM session WHERE ID='$ssID';";
    mysqli_query($con,$sql);
    session_destroy();
?>