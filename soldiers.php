<html>
<?php
    session_start();
    if (!isset($_SESSION['id'])){
        $msg ='ACCESS DENIED!';
        echo "alert('$msg')" ;
        echo "location.href='index.php'";
    }else{
        include ("connection.php");
        $id=$_SESSION['id'];
    }
    error_reporting(E_ALL);

?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style2.css">
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="icon" href="img/enblem.png">
    <title>Soldiers Portal</title>
    <script src="https://kit.fontawesome.com/d989eee63d.js" crossorigin="anonymous"></script>
</head>
    <div class="header">
        <img src="img/enblem.png" onclick="location.href='index.php'">
        <text>Duty Roster & Course Management Portal</text>
        <a href="Logout.php" style="font-size: 30px;"><i class="fa fa-sign-out" aria-hidden="true"></i></a></text>
        <a href="help.php"> Help</a>
        
    </div>
    <div class="container-left">
            <?php 
                    include("connection.php");
                    $sql = "SELECT * from soldiers WHERE ID='$id';";  
					$result = $con->query($sql);
                    $row=$result->fetch_assoc();
            ?>
            <table>
                <tr>
                    <td>Personal Number </td>
                    <td><?php echo $row['PERSONAL_NUMBER']; ?></td>
                </tr>
                <tr>
                    <td>Name </td>
                    <td><?php echo $row['NAME']; ?></td>
                </tr>
                <tr>
                    <td>Rank </td>
                    <td><?php echo $row['RANK']; ?></td>
                </tr>
                <tr>
                    <td>Company </td>
                    <td><?php echo $row['COMPANY']; ?></td>
                </tr>
                <tr>
                    <td>Phone </td>
                    <td><?php echo $row['PHONE']; ?></td>
                </tr>
                <tr>
                    <td>Address </td>
                    <td><?php echo $row['ADDRESS']; ?></td>
                </tr>
            </table>
    </div>
    <div class="container-right-1">
            <?php 
                    $date= date("Y/m/d");
                    $q = "SELECT DUTY,DATE,DUTYTYPE,SHIFT FROM dutyroster WHERE S_ID='$id' AND DATE>='$date' ORDER BY DATE ASC;" ;  
                    $res = mysqli_query($con,$q) or die(mysqli_error($con));
                    $rw = mysqli_fetch_row($res);
            ?>
            <h2 style="color:green; font-family:'Arial'; padding-bottom:5px;"> Duty Roster</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Duty</th>
                    <th>Shift</th>
                    <th>Responsibility</th>
                </tr>
                <?php 
                    while($rw != null){
                ?>
                <tr>
                    <th><?php echo $rw[1]; ?></th>
                    <td><?php echo $rw[0]; ?></td>
                    <td><?php echo $rw[3]; ?></td>
                    <td><?php echo $rw[2]; ?></td>
                </tr>
                <?php $rw = mysqli_fetch_row($res); }
                ?>
            </table>
            <?php
                    $ql = "SELECT DUTY,DATE,DUTYTYPE,SHIFT FROM dutyroster WHERE S_ID='$id' AND DATE<'$date' ORDER BY DATE ASC;" ;  
                    $resu = mysqli_query($con,$ql) or die(mysqli_error($con));
                    $rw2 = mysqli_fetch_row($resu);
            ?>
            <h2 style="color:green; font-family:'Arial'; padding-top:5px; padding-bottom:5px;">Previous Duty Roster</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Duty</th>
                    <th>Shift</th>
                    <th>Responsibility</th>
                </tr>
                <?php 
                    while($rw2 != null){
                ?>
                <tr>
                    <td><?php echo $rw2[1]; ?></td>
                    <td><?php echo $rw2[0]; ?></td>
                    <td><?php echo $rw2[3]; ?></td>
                    <td><?php echo $rw2[2]; ?></td>
                </tr>
                <?php $rw2 = mysqli_fetch_row($res); }
                ?>
            </table>
    </div>
</body>
</html>