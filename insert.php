<?php 
    session_start();
    include ("connection.php");
    if (isset($_SESSION['id']) && ($_SESSION['id']=='bsm'||$_SESSION['id']=='duty_clk'||$_SESSION['id']=='bn_daily')){
        //header("location: index.php");
                $pN = $_POST['pN'];  
                $duty= $_POST['duty'];  
                $dutytype=$_POST['dutytype'];
                $date=$_POST['date'];
                $shift=$_POST['shift'];
                $sql="SELECT ID FROM soldiers WHERE PERSONAL_NUMBER='$pN';";
                $result = mysqli_query($con, $sql);   
                $row=$result->fetch_assoc();
                $sid=$row['ID'];
                $sql2="INSERT INTO dutyroster(S_ID,DUTY,SHIFT,DUTYTYPE,DATE) VALUES('$sid','$duty','$shift','$dutytype','$date'); ";
                if (mysqli_query($con, $sql2)) {
                    $msg1 ='Successfully Updated!';
                    echo "<script>alert('$msg1'); location.href='staff_soldier.php'</script>" ;
                } else {
                    $msg2 ='Error in Updating!';
                    echo "<script>alert('$msg2'); location.href='staff_soldier.php'</script>" ;
                }
    }    
    else if((isset($_SESSION['id']) && preg_match('/^admin/',$_SESSION['id'])||preg_match('/^user/',$_SESSION['id']))){
        if(isset($_POST['Insert']) && $_SESSION['Page']=='Duty Roster'){
                $pN = $_POST['pN'];  
                $duty= $_POST['duty'];  
                $dutytype=$_POST['dutytype'];
                $date=$_POST['date'];
                $shift=$_POST['shift'];
                $sql="SELECT soldiers.ID FROM soldiers ,dutyroster ,specialdutyroster  WHERE soldiers.PERSONAL_NUMBER='$pN' AND dutyroster.S_ID=soldiers.ID AND (dutyroster.DATE='$date' OR specialdutyroster.DATE='$date');";
                $result = mysqli_query($con,$sql) or die(mysqli_error($con));
                $row = mysqli_fetch_row($result); 
                if($row==null){
                    $sql2="SELECT ID FROM soldiers WHERE PERSONAL_NUMBER='$pN';";
                    $result2 = mysqli_query($con,$sql2) or die(mysqli_error($con));
                    $row2 = mysqli_fetch_assoc($result2);
                    $sid=$row2['ID'];
                    $sql2="INSERT INTO dutyroster(S_ID,DUTY,SHIFT,DUTYTYPE,DATE) VALUES('$sid','$duty','$shift','$dutytype','$date'); ";
                    if (mysqli_query($con, $sql2)) {
                            $msg1 ='Successfully Updated!';
                            if($_SESSION['id']=='admin'){
                                echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                            }else{
                                if(preg_match('/^admin/',$_SESSION['id'])){
                                    echo "<script>alert('$msg1'); location.href='staff_officer.php'</script>" ;
                                }else{
                                    echo "<script>alert('$msg1'); location.href='company_commander.php'</script>" ;
                                }
                            }
                    }
                    else {
                        $msg2 ='Error in Updating!';
                        if($_SESSION['id']=='admin'){
                            echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                        }else{
                            if(preg_match('/^admin/',$_SESSION['id'])){
                                echo "<script>alert('$msg2'); location.href='staff_officer.php'</script>" ;
                            }else{
                                echo "<script>alert('$msg2'); location.href='company_commander.php'</script>" ;
                            }
                        }
                    }
                }else{
                    $msg2 ='Error: Soldier Was Already A Duty Assigned On That Day!';
                    if($_SESSION['id']=='admin'){
                        echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                    }else{
                        if(preg_match('/^admin/',$_SESSION['id'])){
                            echo "<script>alert('$msg2'); location.href='staff_officer.php'</script>" ;
                        }else{
                            echo "<script>alert('$msg2'); location.href='company_commander.php'</script>" ;
                        }
                    }
                }
        }
        else if(isset($_POST['Insert']) && $_SESSION['Page']=='Special Duty Roster'){
            $pN = $_POST['pN'];  
            $duty= $_POST['duty'];  
            $dutytype=$_POST['dutytype'];
            $date=$_POST['date'];
            $shift=$_POST['shift'];
            $sql="SELECT soldiers.ID FROM soldiers,specialdutyroster,dutyroster WHERE soldiers.PERSONAL_NUMBER='$pN' AND specialdutyroster.S_ID=soldiers.ID AND (specialdutyroster.DATE='$date' OR dutyroster.DATE='$date');";
                $result = mysqli_query($con,$sql) or die(mysqli_error($con));
                $row = mysqli_fetch_row($result); 
                if($row==null){
                    $sql2="SELECT ID FROM soldiers WHERE PERSONAL_NUMBER='$pN';";
                    $result2 = mysqli_query($con,$sql2) or die(mysqli_error($con));
                    $row2 = mysqli_fetch_assoc($result2);
                    $sid=$row2['ID'];
                    $sql2="INSERT INTO specialdutyroster(S_ID,DUTY,SHIFT,DUTYTYPE,DATE) VALUES('$sid','$duty','$shift','$dutytype','$date'); ";
                    if (mysqli_query($con, $sql2)) {
                            $msg1 ='Successfully Updated!';
                            if($_SESSION['id']=='admin'){
                                echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                            }else{
                                if(preg_match('/^admin/',$_SESSION['id'])){
                                    echo "<script>alert('$msg1'); location.href='staff_officer.php'</script>" ;
                                }else{
                                    echo "<script>alert('$msg1'); location.href='company_commander.php'</script>" ;
                                }
                            }
                    }
                    else {
                        $msg2 ='Error in Updating!';
                        if($_SESSION['id']=='admin'){
                            echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                        }else{
                            if(preg_match('/^admin/',$_SESSION['id'])){
                                echo "<script>alert('$msg2'); location.href='staff_officer.php'</script>" ;
                            }else{
                                echo "<script>alert('$msg2'); location.href='company_commander.php'</script>" ;
                            }
                        }
                    }
                }else{
                    $msg2 ='Error: Soldier Was Already A Duty Assigned On That Day!';
                    if($_SESSION['id']=='admin'){
                        echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                    }else{
                        if(preg_match('/^admin/',$_SESSION['id'])){
                            echo "<script>alert('$msg2'); location.href='staff_officer.php'</script>" ;
                        }else{
                            echo "<script>alert('$msg2'); location.href='company_commander.php'</script>" ;
                        }
                    }
                }
        }
        else if(isset($_POST['Insert']) && $_SESSION['Page']=='Training Statistics'){
            $pN = $_POST['pN'];  
            $cid= $_POST['cid'];  
            $remark=$_POST['remark'];
            $description=$_POST['description'];
            $date=$_POST['date'];
            $id=$_SESSION['id'];
            $sql="SELECT ID FROM soldiers WHERE PERSONAL_NUMBER='$pN';";
            $result=mysqli_query($con,$sql);
            $row = $result->fetch_assoc();
            $sid=$row['ID'];
            $sql2="INSERT INTO coursestat(S_ID,C_ID,REMARK,DESCRIPTION,DATE) VALUES('$sid','$cid','$remark','$description','$date'); ";
            if (mysqli_query($con, $sql2)) {
                $msg1 ='Successfully Updated!';
                if($_SESSION['id']=='admin'){
                    echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                }else{
                    if(preg_match('/^admin/',$_SESSION['id'])){
                        echo "<script>alert('$msg1'); location.href='staff_officer.php'</script>" ;
                    }else{
                        echo "<script>alert('$msg1'); location.href='company_commander.php'</script>" ;
                    }
                }
            }
            else {
                $msg2 ='Error in Updating!';
                if($_SESSION['id']=='admin'){
                    echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                }else{
                    if(preg_match('/^admin/',$_SESSION['id'])){
                        echo "<script>alert('$msg'); location.href='staff_officer.php'</script>" ;
                    }else{
                        echo "<script>alert('$msg'); location.href='company_commander.php'</script>" ;
                    }
                }
            }
        }else if(isset($_POST['Insert']) && $_SESSION['Page']=='Soldier Recruitment'){
            $pN = $_POST['pN'];  
            $name= $_POST['name'];  
            $rank=$_POST['rank'];
            $dob=$_POST['dob'];
            $address=$_POST['address'];
            $company=$_POST['company'];
            $phone=$_POST['phone'];
            $password='123456';
            $sql="INSERT INTO soldiers(NAME,RANK,ADDRESS,PHONE,DOB,PERSONAL_NUMBER,COMPANY,PASSWORD) VALUES('$name','$rank','$address','$phone','$dob','$pN','$company','$password'); ";
            if (mysqli_query($con, $sql)) {
                $msg1 ='Successfully Updated!';
                if($_SESSION['id']=='admin'){
                    echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
                }else{
                    if(preg_match('/^admin/',$_SESSION['id'])){
                        echo "<script>alert('$msg1'); location.href='staff_officer.php'</script>" ;
                    }else{
                        echo "<script>alert('$msg1'); location.href='company_commander.php'</script>" ;
                    }
                }
            }
            else {
                $msg2 ='Error in Updating!';
                if($_SESSION['id']=='admin'){
                    echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
                }else{
                    if(preg_match('/^admin/',$_SESSION['id'])){
                        echo "<script>alert('$msg'); location.href='staff_officer.php'</script>" ;
                    }else{
                        echo "<script>alert('$msg'); location.href='company_commander.php'</script>" ;
                    }
                }
            }
        }
    }
    else{
        $msg ='Unauthorized Access Attempt!';
        if($_SESSION['id']=='admin'){
            echo "<script>alert('$msg'); location.href='commanding.php'</script>" ;
        }else{
            if(preg_match('/^admin/',$_SESSION['id'])){
                echo "<script>alert('$msg'); location.href='staff_officer.php'</script>" ;
            }else{
                echo "<script>alert('$msg'); location.href='company_commander.php'</script>" ;
            }
        }
    } 
    if(isset($_SESSION['id']) && $_SESSION['id']=='admin'){
        if(isset($_POST['Insert']) && $_SESSION['Page']=='Soldier Review'){
            $pN = $_POST['pN'];  
            $disposal= $_POST['disposal'];  
            $remark=$_POST['remark'];
            $date=$_POST['date'];
            $type=$_POST['type'];
            $sql="SELECT ID FROM soldiers WHERE PERSONAL_NUMBER='$pN';";
            $result = mysqli_query($con, $sql);   
            $row=$result->fetch_assoc();
            $sid=$row['ID'];
            $sql2="INSERT INTO observation(TYPE,DISPOSAL,REMARK,S_ID,DATE) VALUES('$type','$disposal','$remark','$sid','$date'); ";
            if (mysqli_query($con, $sql2)) {
                $msg1 ='Successfully Updated!';
                echo "<script>alert('$msg1'); location.href='commanding.php'</script>" ;
            } else {
                $msg2 ='Error in Updating!';
                echo "<script>alert('$msg2'); location.href='commanding.php'</script>" ;
            }
        }
    }
    else{
        $msg ='Unauthorized Access Attempt!';
        echo "<script>alert('$msg'); location.href='index.php'</script>";
    }
    error_reporting(E_ALL);
?>