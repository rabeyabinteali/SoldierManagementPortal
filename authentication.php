<?php
session_start();
include('connection.php');
if(isset($_POST['Login'])){
    $pN = $_POST['pN'];  
    $password = $_POST['password'];   
        if(preg_match("/^[0-9]+$/",$pN)){
            $sql="SELECT * FROM soldiers WHERE PERSONAL_NUMBER='$pN' AND PASSWORD='$password';";
            $result = mysqli_query($con, $sql);  
            $count = mysqli_num_rows($result);  
            if($count == 1){  
               $row=$result->fetch_assoc();
               $_SESSION['id']=$row['ID'];
               header("location: soldiers.php");

            }else{  
                $msg ='Incorrect Credentials!';
                echo "<script>alert('$msg'); location.href='index.php'</script>";
            }    
        }
        else{
                $sql="SELECT * FROM admin WHERE ID='$pN' AND PASSWORD='$password';";
                $result = mysqli_query($con, $sql);  
                $count = mysqli_num_rows($result);  
                if($pN=="admin"){
                    if($count == 1){  
                    $row=$result->fetch_assoc();
                    $_SESSION['id']=$row['ID'];
                    header("location: commanding.php");
                    }else{  
                        $msg ='Incorrect Credentials!';
                        echo "<script>alert('$msg'); location.href='index.php'</script>";
                    }   
                }
                else if(($pN=="admin2")||($pN=="admin3")||($pN=="admin4")){
                    if($count == 1){  
                    $row=$result->fetch_assoc();
                    $_SESSION['id']=$row['ID'];
                    header("location: staff_officer.php");
                    }else{  
                        $msg ='Incorrect Credentials!';
                        echo "<script>alert('$msg'); location.href='index.php'</script>";
                    }   
                }else if($pN=="officers"){
                    if($count == 1){  
                        $row=$result->fetch_assoc();
                        $_SESSION['id']=$row['ID'];
                        header("location: officers.php");
                    }
                    else{  
                        $msg ='Incorrect Credentials!';
                        echo "<script>alert('$msg'); location.href='index.php'</script>";
                    }   
                }
                else if(($pN=="user_rr")||($pN=="user_rdo")||($pN=="user_op")||($pN=="user_hq")){
                    if($count == 1){  
                        $row=$result->fetch_assoc();
                        $_SESSION['id']=$row['ID'];
                        header("location: company_commander.php");
                    }else{  
                        $msg ='Incorrect Credentials!';
                        echo "<script>alert('$msg'); location.href='index.php'</script>";
                    }   
                }
                else if(($pN=="bn_daily")||($pN=="bsm")||($pN="duty_clk")){
                    if($count == 1){  
                        $row=$result->fetch_assoc();
                        $_SESSION['id']=$row['ID'];
                        header("location: staff_soldier.php");
                    }else{  
                        $msg ='Incorrect Credentials!';
                        echo "<script>alert('$msg'); location.href='index.php'</script>";
                    }   
                }
            }
    } 
?>  