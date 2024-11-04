<html>
<?php
    session_start();

?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style3.css">
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="icon" href="img/enblem.png">
    <title>Help Portal</title>
    <script src="https://kit.fontawesome.com/d989eee63d.js" crossorigin="anonymous"></script>
</head>
    <div class="header">
        <img src="img/enblem.png" onclick="location.href='index.php'">
        <text>Duty Roster & Course Management Portal</text>
        <?php if(!isset($_SESSION['id'])){
        ?>
        <a href="index.php"> Home</a>
        <?php 
        }else{
            if($_SESSION['id']=='admin'){
                echo "<a href='commanding.php'> Home</a>";
            }else if($_SESSION['id']=='admin2'||$_SESSION['id']=='admin3'||$_SESSION['id']=='admin4'){
                echo "<a href='staff_officer.php'> Home</a>";
            }else if($_SESSION['id']=='bn_daily'||$_SESSION['id']=='bsm'||$_SESSION['id']=='duty_clk'){
                echo "<a href='staff_soldier.php'> Home</a>";
            }else if($_SESSION['id']=='user_hq'||$_SESSION['id']=='user_rdo'||$_SESSION['id']=='user_rr'||$_SESSION['id']=='user_op'){
                echo "<a href='company_commander.php'> Home</a>";
            }else if($_SESSION['id']=='officers'){
                echo "<a href='officers.php'> Home</a>";
            }else if(preg_match("/^[0-9]+$/",$_SESSION['id'])){
                echo "<a href='soldiers.php'> Home</a>";
            }
        }
        ?>
    </div>
    <div class="container">
        <h1 style="text-align:center;font-size:52px;">Support Contact</h1>
        <br><br><br>
        <h3 style="text-align:center;">+8801304456175</h3>
        <h3 style="text-align:center;">Lieutenant</h3>
        <h3 style="text-align:center;">Shoaib Ahmed Sami</h3>
    </div>
</body>
</html>