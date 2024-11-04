<html>
<?php
    session_start();
    if (!isset($_SESSION['id']) && ($_SESSION['id']!='officers')){
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
    <link rel="stylesheet" type="text/css" href="style3.css">
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="icon" href="img/enblem.png">
    <title>Officers Portal</title>
    <script src="https://kit.fontawesome.com/d989eee63d.js" crossorigin="anonymous"></script>
</head>
    <div class="header">
        <img src="img/enblem.png" onclick="location.href='index.php'">
        <text>Duty Roster & Course Management Portal</text>
        <a href="Logout.php" style="font-size: 30px;"><i class="fa fa-sign-out" aria-hidden="true"></i></a></text>
        <a href="help.php"> Help</a>
        
    </div>
    <div class="container">
            <div class="container-header" style="display:flex;">
                <h3 style=" padding-right:10%;"> Duty Roster</h3>
                <form action="" method="get" style="height:30px; width:50%;">
                <input type="text" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>" name="search" placeholder="Search Data" style="border-radius:15px; border:2px;margin-top:5px; text-align:center; width:60%; height:100%; background-color:#F2F4F4 ;">
                <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <table>
                <tr>
                    <th>P.N.</th>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Duty</th>
                    <th>Shift</th>
                    <th>Company</th>
                    <th>Date</th>
                </tr>
                <?php 
                    include("connection.php");
                    if(isset($_GET['search'])){
                        $filter=$_GET['search'];
                        $sql="SELECT PERSONAL_NUMBER,NAME,RANK,DUTY,SHIFT,COMPANY,DATE from soldiers,dutyroster WHERE soldiers.ID=dutyroster.S_ID AND CONCAT(PERSONAL_NUMBER,NAME,DATE,DUTY,COMPANY,SHIFT,RANK) LIKE '%$filter%' ORDER BY DATE ASC; ";
                    }else{
                    $sql = "SELECT PERSONAL_NUMBER,NAME,RANK,DUTY,SHIFT,COMPANY,DATE from soldiers,dutyroster WHERE soldiers.ID=dutyroster.S_ID ORDER BY DATE ASC;";  
                    }
                    $result = mysqli_query($con,$sql) or die(mysqli_error($con));
                    $row = mysqli_fetch_row($result);
                    while($row != null){
                ?>
                <tr>
                    <th><?php echo $row[0]; ?></th>
                    <td><?php echo $row[1]; ?></td>
                    <td><?php echo $row[2]; ?></td>
                    <td><?php echo $row[3]; ?></td>
                    <td><?php echo $row[4]; ?></td>
                    <td><?php echo $row[5]; ?></td>
                    <td><?php echo $row[6]; ?></td>
                </tr>
                <?php $row = mysqli_fetch_row($result); }
                ?>
            </table>
    </div>
</body>
</html>