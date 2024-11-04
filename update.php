<?php 
    session_start();
    include ("connection.php");
    if (isset($_SESSION['id']) && ($_SESSION['id']=='bsm'||$_SESSION['id']=='duty_clk'||$_SESSION['id']=='bn_daily')){
        //header("location: index.php");
            if(isset($_POST['Update']) && (!isset($_SESSION['Page']))){
                $id = $_POST['id'];
                $pN = $_POST['pN'];  
                $duty= $_POST['duty'];  
                $dutytype=$_POST['dutytype'];
                $date=$_POST['date'];
                $shift=$_POST['shift'];
                $sql="SELECT * FROM dutyroster WHERE ID='$id';";
                $result = mysqli_query($con, $sql);  
                $count = mysqli_num_rows($result);  
                if($count == 1){ 
                    $sql="SELECT ID FROM soldiers WHERE PERSONAL_NUMBER='$pN';";
                    $result = mysqli_query($con, $sql);   
                    $row=$result->fetch_assoc();
                    $sid=$row['ID'];
                    $sql2="UPDATE dutyroster SET DUTY='$duty', DUTYTYPE='$dutytype', SHIFT='$shift',DATE='$date', S_ID='$sid' WHERE ID= '$id'; ";
                    if (mysqli_query($con, $sql2)) {
                        $msg1 ='Successfully Updated!';
                        echo "<script>alert('$msg1'); location.href='staff_soldier.php'</script>" ;
                    } else {
                        $msg2 ='Error in Updating!';
                        echo "<script>alert('$msg2'); location.href='staff_soldier.php'</script>" ;
                    }
                }else{
                    echo $con->error;
                    $msg ='Inconsistent Data Entry Attempt!';
                    echo "<script>alert('$msg'); location.href='staff_soldier.php'</script>";
                }
        }
    }    
    else if(isset($_SESSION['id']) && (preg_match('/^admin/',$_SESSION['id'])||preg_match('/^user/',$_SESSION['id']))){
        if(isset($_POST['Update']) && $_SESSION['Page']=='Duty Roster'){

            $id = $_POST['id'];
            $pN = $_POST['pN'];  
            $duty= $_POST['duty'];  
            $dutytype=$_POST['dutytype'];
            $date=$_POST['date'];
            $shift=$_POST['shift'];
            $sql="SELECT * FROM dutyroster WHERE ID='$id';";
            $result = mysqli_query($con, $sql);  
            $count = mysqli_num_rows($result);  
            if($count == 1){ 
                $sql="SELECT ID FROM soldiers WHERE PERSONAL_NUMBER='$pN';";
                $result = mysqli_query($con, $sql);   
                $row=$result->fetch_assoc();
                $sid=$row['ID'];
                $sql2="UPDATE dutyroster SET DUTY='$duty', DUTYTYPE='$dutytype', SHIFT='$shift',DATE='$date', S_ID='$sid' WHERE ID= '$id'; ";
                if (mysqli_query($con, $sql2)) {
                    $msg1 ='Successfully Updated!';
                    if($_SESSION['id']=='admin'){
                        echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                    }else{
                        echo "<script>alert('$msg1'); location.href='staff_officer.php'</script>" ;
                    }
                } else {
                    $msg2 ='Error in Updating!';
                    if($_SESSION['id']=='admin'){
                        echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                    }else{
                        echo "<script>alert('$msg2'); location.href='staff_officer.php'</script>" ;
                    }
                }
            }else{
                $msg ='Inconsistent Data Entry Attempt!';
                if($_SESSION['id']=='admin'){
                    echo "<script>alert('$msg'); location.href='commanding.php'</script>" ;
                }else{
                    echo "<script>alert('$msg'); location.href='staff_officer.php'</script>" ;
                }
            }
        }
        if(isset($_POST['Delete']) && $_SESSION['Page']=='Duty Roster'){
                    $id = $_POST['id'];
                    $sql="SELECT * FROM dutyroster WHERE ID='$id';";
                    $result = mysqli_query($con, $sql);  
                    $count = mysqli_num_rows($result);  
                    if($count == 1){ 
                        $sql2="DELETE FROM dutyroster WHERE ID='$id';";
                        if (mysqli_query($con, $sql2)) {
                            $msg1 ='Successfully Updated!';
                            if($_SESSION['id']=='admin'){
                                echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                            }else{
                                echo "<script>alert('$msg1'); location.href='staff_officer.php'</script>" ;
                            }
                        } else {
                            $msg2 ='Error in Updating!';
                            if($_SESSION['id']=='admin'){
                                echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                            }else{
                                echo "<script>alert('$msg2'); location.href='staff_officer.php'</script>" ;
                            }
                        }
                    }else{
                        echo $con->error;
                        $msg ='Inconsistent Data Entry Attempt!';
                        if($_SESSION['id']=='admin'){
                            echo "<script>alert('$msg'); location.href='commanding.php'</script>" ;
                        }else{
                            echo "<script>alert('$msg'); location.href='staff_officer.php'</script>" ;
                        }
                    }
        }
        if(isset($_POST['Update']) && $_SESSION['Page']=='Training Statistics'){
            $id=$_POST['id'];
            $pN = $_POST['pN'];  
            $cid= $_POST['cid'];  
            $remark=$_POST['remark'];
            $description=$_POST['description'];
            $date=$_POST['date'];
            $sql="SELECT * FROM coursestat WHERE ID='$id';";
            $result = mysqli_query($con, $sql);  
            $count = mysqli_num_rows($result);  
            if($count == 1){ 
                $sql="SELECT ID FROM soldiers WHERE PERSONAL_NUMBER='$pN';";
                $result = mysqli_query($con, $sql);   
                $row=$result->fetch_assoc();
                $sid=$row['ID'];
                $sql2="UPDATE coursestat SET C_ID='$cid', REMARK='$remark', DESCRIPTION='$description',DATE='$date', S_ID='$sid' WHERE ID= '$id'; ";
                if (mysqli_query($con, $sql2)) {
                    $msg1 ='Successfully Updated!';
                    if($_SESSION['id']=='admin'){
                        echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                    }else{
                        echo "<script>alert('$msg1'); location.href='staff_officer.php'</script>" ;
                    }
                } else {
                    $msg2 ='Error in Updating!';
                    if($_SESSION['id']=='admin'){
                        //echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                    }else{
                        echo $con->error;
                        //echo "<script>alert('$msg2'); location.href='staff_officer.php'</script>" ;
                    }
                }
            }else{
                echo $con->error;
                $msg ='Inconsistent Data Entry Attempt!';
                if($_SESSION['id']=='admin'){
                    echo "<script>alert('$msg'); location.href='commanding.php'</script>" ;
                }else{
                    echo "<script>alert('$msg'); location.href='staff_officer.php'</script>" ;
                }
            }
        }
        if(isset($_POST['Update']) && $_SESSION['Page']=='Special Duty Roster'){

            $id = $_POST['id'];
            $pN = $_POST['pN'];  
            $duty= $_POST['duty'];  
            $dutytype=$_POST['dutytype'];
            $date=$_POST['date'];
            $shift=$_POST['shift'];
            $sql="SELECT * FROM specialdutyroster WHERE ID='$id';";
            $result = mysqli_query($con, $sql);  
            $count = mysqli_num_rows($result);  
            if($count == 1){ 
                $sql="SELECT ID FROM soldiers WHERE PERSONAL_NUMBER='$pN';";
                $result = mysqli_query($con, $sql);   
                $row=$result->fetch_assoc();
                $sid=$row['ID'];
                $sql2="UPDATE specialdutyroster SET DUTY='$duty', DUTYTYPE='$dutytype', SHIFT='$shift',DATE='$date', S_ID='$sid' WHERE ID= '$id'; ";
                if (mysqli_query($con, $sql2)) {
                    $msg1 ='Successfully Updated!';
                    if($_SESSION['id']=='admin'){
                        echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                    }else{
                        echo "<script>alert('$msg1'); location.href='staff_officer.php'</script>" ;
                    }
                } else {
                    $msg2 ='Error in Updating!';
                    if($_SESSION['id']=='admin'){
                        echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                    }else{
                        echo "<script>alert('$msg2'); location.href='staff_officer.php'</script>" ;
                    }
                }
            }else{
                $msg ='Inconsistent Data Entry Attempt!';
                if($_SESSION['id']=='admin'){
                    echo "<script>alert('$msg'); location.href='commanding.php'</script>" ;
                }else{
                    echo "<script>alert('$msg'); location.href='staff_officer.php'</script>" ;
                }
            }
        }
        if(isset($_POST['Delete']) && $_SESSION['Page']=='Special Duty Roster'){
                    $id = $_POST['id'];
                    $sql="SELECT * FROM specialdutyroster WHERE ID='$id';";
                    $result = mysqli_query($con, $sql);  
                    $count = mysqli_num_rows($result);  
                    if($count == 1){ 
                        $sql2="DELETE FROM specialdutyroster WHERE ID='$id';";
                        if (mysqli_query($con, $sql2)) {
                            $msg1 ='Successfully Updated!';
                            if($_SESSION['id']=='admin'){
                                echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                            }else{
                                echo "<script>alert('$msg1'); location.href='staff_officer.php'</script>" ;
                            }
                        } else {
                            $msg2 ='Error in Updating!';
                            if($_SESSION['id']=='admin'){
                                echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                            }else{
                                echo "<script>alert('$msg2'); location.href='staff_officer.php'</script>" ;
                            }
                        }
                    }else{
                        echo $con->error;
                        $msg ='Inconsistent Data Entry Attempt!';
                        if($_SESSION['id']=='admin'){
                            echo "<script>alert('$msg'); location.href='commanding.php'</script>" ;
                        }else{
                            echo "<script>alert('$msg'); location.href='staff_officer.php'</script>" ;
                        }
                    }
        }
        if(isset($_POST['Update']) && $_SESSION['Page']=='Soldier Recruitment'){
            $id = $_POST['id'];
            $name= $_POST['name'];  
            $rank=$_POST['rank'];
            $address=$_POST['address'];
            $company=$_POST['company'];
            $dob=$_POST['dob'];
            $phone=$_POST['phone'];
            $sql="UPDATE soldiers SET ID='$id', NAME='$name', RANK='$rank',DOB='$dob', ADDRESS='$address', COMPANY='$company', PHONE='$phone' WHERE ID= '$id'; ";
            if (mysqli_query($con, $sql)) {
                $msg1 ='Successfully Updated!';
                if($_SESSION['id']=='admin'){
                    echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                }else{
                    echo "<script>alert('$msg1'); location.href='staff_officer.php'</script>" ;
                }
            } else {
                $msg2 ='Error in Updating!';
                if($_SESSION['id']=='admin'){
                    echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                }else{
                    echo "<script>alert('$msg2'); location.href='staff_officer.php'</script>" ;
                }
            }
        }
        if(isset($_POST['Delete']) && $_SESSION['Page']=='Soldier Recruitment'){
                    $id = $_POST['id'];
                    $sql="DELETE FROM soldiers WHERE ID='$id';";
                        if (mysqli_query($con, $sql)) {
                            $msg1 ='Successfully Updated!';
                            if($_SESSION['id']=='admin'){
                                echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                            }else{
                                echo "<script>alert('$msg1'); location.href='staff_officer.php'</script>" ;
                            }
                        } else {
                            $msg2 ='Error in Updating!';
                            if($_SESSION['id']=='admin'){
                                echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                            }else{
                                echo "<script>alert('$msg2'); location.href='staff_officer.php'</script>" ;
                            }
                        }
        }
    }
    else{
        $msg ='Unauthorized Access Attempt!';
        echo "<script>alert('$msg'); location.href='staff_soldier.php'</script>";
    }
    if(isset($_SESSION['id']) && $_SESSION['id']=='admin'){
        if(isset($_POST['Update']) && $_SESSION['Page']=='Soldier Review'){
            $id=$_POST['id'];
            $pN = $_POST['pN'];  
            $type= $_POST['type'];  
            $remark=$_POST['remark'];
            $disposal=$_POST['disposal'];
            $date=$_POST['date'];
            $sql="SELECT * FROM observation WHERE ID='$id';";
            $result = mysqli_query($con, $sql);  
            $count = mysqli_num_rows($result);  
            if($count == 1){ 
                $sql="SELECT ID FROM soldiers WHERE PERSONAL_NUMBER='$pN';";
                $result = mysqli_query($con, $sql);   
                $row=$result->fetch_assoc();
                $sid=$row['ID'];
                $sql2="UPDATE observation SET S_ID='$sid', REMARK='$remark', disposal='$disposal',DATE='$date', TYPE='$type' WHERE ID= '$id'; ";
                if (mysqli_query($con, $sql2)) {
                    $msg1 ='Successfully Updated!';
                    echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                } else {
                    $msg2 ='Error in Updating!';
                    echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                }
            }else{
                echo $con->error;
                $msg ='Inconsistent Data Entry Attempt!';
                echo "<script>alert('$msg'); location.href='commanding.php'</script>";
            }
        }
        if(isset($_POST['Delete']) && $_SESSION['Page']=='Soldier Review'){
            $id = $_POST['id'];
            $sql="SELECT * FROM observation WHERE ID='$id';";
            $result = mysqli_query($con, $sql);  
            $count = mysqli_num_rows($result);  
            if($count == 1){ 
                $sql2="DELETE FROM observation WHERE ID='$id';";
                if (mysqli_query($con, $sql2)) {
                    $msg1 ='Successfully Updated!';
                    echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                } else {
                    $msg2 ='Error in Updating!';
                    echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                }
            }
        }
    }
    else{
        $msg ='Unauthorized Access Attempt!';
        echo "<script>alert('$msg'); location.href='index.php'</script>";
    }
    error_reporting(E_ALL);
?>