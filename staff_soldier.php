<html>
<?php
    session_start();
    $ssID=$_SESSION['id'];
    if (!isset($_SESSION['id']) && ($_SESSION['id']!='bsm'||$_SESSION['id']!='duty_clk'||$_SESSION['id']!='bn_daily'||(preg_match("/^admin[2-4]$/",$_SESSION['id'])))){
        $msg ='ACCESS DENIED!';
        echo "<script>alert('$msg');location.href='index.php'</script>";
    }else{
        include ("connection.php");
        $id=$_SESSION['id'];
    }
    error_reporting(E_ALL);

?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style3.css">
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="icon" href="img/enblem.png">
    <title>Staff Soldiers Portal</title>
    <script src="https://kit.fontawesome.com/d989eee63d.js" crossorigin="anonymous"></script>
</head>
    <div class="header">
        <img src="img/enblem.png" onclick="location.href='index.php'">
        <text>Duty Roster & Course Management Portal</text>
        <a href="Logout.php" style="font-size: 30px;"><i class="fa fa-sign-out" aria-hidden="true"></i></a></text>
        <a href="help.php"> Help</a>
        <?php 
            $id=$_SESSION['id'];
            $sql="SELECT * FROM admin WHERE ID='$id'";
            $result = mysqli_query($con, $sql);  
            $row=$result->fetch_assoc();
        ?>
        <table style="height:100%; width:30%;">
            <tr><td><?php echo $row['POST']; ?></td></tr>
            <tr><td><?php echo $row['RANK']." ".$row['NAME']; ?></td></tr>
        </table>
        
    </div>
    <div class="container">
        <?php
            $s2="INSERT into session (ID,TABLENAME) VALUES('$ssID','dutyroster');";
            mysqli_query($con, $s2);
        ?>
            <div class="container-header" style="display:flex;">
                <h3 style=" padding-right:10%;"> Duty Roster</h3>
                <form action="" method="" style="height:30px; width:50%;">
                <input type="text" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>" name="search" placeholder="Search Data" style="border-radius:15px; border:2px;margin-top:5px; text-align:center; width:60%; height:100%; background-color:#F2F4F4 ;">
                <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
                <div style="background-color: #ABE3A4; margin-top:5px;">
                <?php 
                     echo "<table><tr><form action='insert.php' method='POST'>";
                     echo "<td><input type=text name=pN placeholder='P.N.'></td>";
                     echo "<td><input type=text name=duty placeholder='Duty'></td>";
                     echo "<td><input type=text name=shift placeholder='Shift'></td>";
                     echo "<td><input type=text name=dutytype placeholder='Responsibility'></td>";
                     echo "<td><input type=text name=date placeholder='Date'></td>";
                     echo "<td><button type=submit value='Insert' name='Insert'>Insert New Duty</button>";
                     echo "</form></tr></table>";
                ?>
                </div>
                 <table>
                <tr>
                    <th>Sl.</th>
                    <th>P.N.</th>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Duty</th>
                    <th>Shift</th>
                    <th>Company</th>
                    <th>Date</th>
                    <th>Role</th>
                </tr>
                <?php 
                    include("connection.php");
                    $pre="SELECT * from session WHERE TABLENAME='dutyroster' AND ID!='$id';";
                    $pre_res = mysqli_query($con,$pre) or die(mysqli_error($con));
                    $row = mysqli_fetch_row($pre_res);
                    if(mysqli_affected_rows($con)!=0){
                        while($row !=null){
                            $_SESSION['Page']='RESET';
                            $_POST['Page']="RESET";
                            $msg="Cannot Access Duty Roster: ".$row[0]." is working on it!";
                            echo "<script>alert('$msg');location.href='staff_officer.php';</script>";
                        }
                    }
                    if(isset($_GET['search'])){
                        $filter=$_GET['search'];
                        $sql="SELECT dutyroster.ID,PERSONAL_NUMBER,NAME,RANK,DUTY,SHIFT,COMPANY,DATE,DUTYTYPE from soldiers,dutyroster WHERE soldiers.ID=dutyroster.S_ID AND CONCAT(PERSONAL_NUMBER,NAME,DATE,DUTY,COMPANY,SHIFT,RANK,DUTYTYPE) LIKE '%$filter%' ORDER BY DATE ASC; ";
                    }else{
                    $sql = "SELECT dutyroster.ID,PERSONAL_NUMBER,NAME,RANK,DUTY,SHIFT,COMPANY,DATE,DUTYTYPE from soldiers,dutyroster WHERE soldiers.ID=dutyroster.S_ID ORDER BY DATE ASC;";  
                    }
                    $result = mysqli_query($con,$sql) or die(mysqli_error($con));
                    $row = mysqli_fetch_row($result);
                    $attr=1;
                    while($row != null){
                        echo "<tr><form action='update.php' method='POST'>";
                        echo "<td><input type=text name=id value= '$row[0]' ></td>";
                        echo "<td><input type=text name=pN value= '$row[1]' ></td>";
                        echo "<td>$row[2]</td>";
                        echo "<td>$row[3]</td>";
                        echo "<td><input type=text name=duty value= '$row[4]' ></td>";
                        echo "<td><input type=text name=shift value= '$row[5]' ></td>";
                        echo "<td>$row[6]</td>";
                        echo "<td><input type=text name=date value= '$row[7]' ></td>";
                        echo "<td><input type=text name=dutytype value= '$row[8]' ></td>";
                        echo "<td><button type=submit value='Update' name='Update'>Submit</button>";
                        echo "</form></tr>";
                    $row = mysqli_fetch_row($result); }
                ?>
            </table>
    </div>
</body>
</html>