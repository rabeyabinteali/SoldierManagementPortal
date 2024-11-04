<html>
<?php
    session_start();
    $ssID=$_SESSION['id'];
    if (!isset($_SESSION['id'])|| (($_SESSION['id']!='admin'))){
        $msg ='ACCESS DENIED!';
        echo "<script>alert('$msg');location.href='index.php'</script>";
    }else{
        include ("connection.php");
        $id=$_SESSION['id'];
    }
    error_reporting(E_ALL);
    ini_set('display_errors','Off');
    $_SESSION["Page"]=$_POST["Page"];
    $flag=0;

?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style4.css">
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="icon" href="img/enblem.png">
    <title>Commander Portal</title>
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
        <table style="height:80%; width:30%;">
            <tr><td><?php echo $row['POST']; ?></td></tr>
            <tr><td><?php echo $row['RANK']." ".$row['NAME']; ?></td></tr>
        </table>
        
    </div>
    <div class="container">
                <?php
                    if((!isset($_POST['Page']) && !isset($_SESSION['Page']))){
                        $flag=-1;
                        echo "
                        <div class='container-header'>
                        <form id='form1' method='POST' action=''>
                        <select name='Page' >
                        <option value='Duty Roster' >Duty Roster</option>
                        <option value='Training Statistics' >Training Statistics</option>
                        <option value='Soldier Review' >Soldier Review</option>
                        <option value='Special Duty Roster' >Special Event Duty</option>
                        <option value='Soldier Recruitment' >Soldier Recruitment</option>
                        </select>
                        <button type='submit' style='font-size:30px; background-color:transparent; border:0px'><i class='fa fa-table'></i></button>
                        </form>
                        <form action='' method='GET' style='height:30px; width:50%;'>
                        <input type='text' value='";
                        if(isset($_GET['search'])){echo $_GET['search'];}
                        echo "' name='search' placeholder='Search Data' style='border-radius:15px; border:2px;margin-top:5px; text-align:center; width:60%; height:100%; background-color:#F2F4F4 ;'>
                        <button type='submit'><i class='fa fa-search'></i></button>
                        </form>
                        </div>
                        ";
                    }
                    if((isset($_POST['Page']) && ($_SESSION['Page']!='RESET'))){
                        $_SESSION['Page']=$_POST['Page'];
                    } 
                    if(isset($_SESSION['Page']) && $_SESSION['Page']=="Duty Roster"){
                        $pre="SELECT * from session WHERE TABLENAME='dutyroster' AND ID!='$id';";
                        $pre_res = mysqli_query($con,$pre) or die(mysqli_error($con));
                        $row = mysqli_fetch_row($pre_res);
                        if(mysqli_affected_rows($con)>=1){
                            while($row !=null){
                                $_SESSION['Page']='RESET';
                                $_POST['Page']="RESET";
                                $msg="Cannot Access Duty Roster: ".$row[0]." is working on it!";
                                echo "<script>alert('$msg');location.href='commanding.php';</script>";
                            }
                        }
                        $s="INSERT into session (ID,TABLENAME) VALUES('$ssID','dutyroster') ON DUPLICATE KEY UPDATE TABLENAME = 'dutyroster';";
                        mysqli_query($con, $s);
                        //if($flag!=-1){
                ?>
                <div class="container-header">
                <form id="form1" method="POST" action="">
                <select name="Page" >
                    <option value="Duty Roster" >Duty Roster</option>
                    <option value="Training Statistics" >Training Statistics</option>
                    <option value="Soldier Review" >Soldier Review</option>
                    <option value="Special Duty Roster" >Speical Event Duty</option>
                    <option value='Soldier Recruitment' >Soldier Recruitment</option>
                </select>
                <button type="submit" style="font-size:30px; background-color:transparent; border:0px"><i class="fa fa-table"></i></button>
                </form>
                <form action="" method="GET" style="height:30px; width:70%;">
                <input type="text" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" name="search" placeholder="Search Data" style="border-radius:15px; border:2px;margin-top:5px; text-align:center; width:60%; height:100%; background-color:#F2F4F4 ;">
                <button type="submit"><i class="fa fa-search"></i></button>
                <?php // } ?>
                <select name="categories"  style="width: 60px; height: 20px; margin-top:10px; font-size:12px;">
                    <option value="any" >Any</option>
                    <option value="soldiers.PERSONAL_NUMBER" >Personal Number</option>
                    <option value="NAME" >Name</option>
                    <option value="RANK" >Rank</option>
                    <option value="dutyroster.DATE" >Date</option>
                    <option value="DUTY" >Duty</option>
                    <option value="SHIFT" >Shift</option>
                    <option value="DESCRIPTION" >Role</option>
                    <option value="COMPANY" >Company</option>
                </select>
                </form>
                </div>
                <div style="background-color: #ABE3A4; margin-top:10px;">
                <?php 
                     echo "<table><tr><form action='insert.php' method='POST'>";
                     echo "<td><input type=text name='pN' placeholder='P.N.'></td>";
                     echo "<td><input type=text name='duty' placeholder='Duty'></td>";
                     echo "<td><input type=text name='shift' placeholder='Shift'></td>";
                     echo "<td><input type=text name='dutytype' placeholder='Responsibility'></td>";
                     echo "<td><input type=text name='date' placeholder='Date'></td>";
                     echo "<td><button type=submit value='Insert' name='Insert'>Insert New Duty</button>";
                     echo "</form></tr></table>";
                ?>
                </div>
                 <table>
                <tr>
                    <th >Sl.</th>
                    <th>P.N.</th>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Duty</th>
                    <th>Shift</th>
                    <th>Company</th>
                    <th>Date</th>
                    <th>Role</th>
                    <td>Action</td>
                </tr>
                <?php 
                    include("connection.php");
                    if(isset($_GET['search'])){
                        $filter=$_GET['search'];
                        if($_GET['categories']=='any'){
                        $sql="SELECT dutyroster.ID,PERSONAL_NUMBER,NAME,RANK,DUTY,SHIFT,COMPANY,DATE,DUTYTYPE from soldiers,dutyroster WHERE soldiers.ID=dutyroster.S_ID AND CONCAT(PERSONAL_NUMBER,NAME,DATE,DUTY,COMPANY,SHIFT,RANK,DUTYTYPE) LIKE '%$filter%' ORDER BY dutyroster.ID ASC; ";
                        }else{
                            $cat=$_GET['categories'];
                            $sql ="SELECT dutyroster.ID,PERSONAL_NUMBER,NAME,RANK,DUTY,SHIFT,COMPANY,DATE,DUTYTYPE from soldiers,dutyroster WHERE soldiers.ID=dutyroster.S_ID AND $cat IN (SELECT $cat FROM soldiers,dutyroster WHERE $cat LIKE '%$filter%') ORDER BY dutyroster.ID ASC; "; 
                        }
                    }else{
                    $sql = "SELECT dutyroster.ID,PERSONAL_NUMBER,NAME,RANK,DUTY,SHIFT,COMPANY,DATE,DUTYTYPE from soldiers,dutyroster WHERE soldiers.ID=dutyroster.S_ID ORDER BY dutyroster.ID ASC;";  
                    }
                    $result = mysqli_query($con,$sql) or die(mysqli_error($con));
                    $row = mysqli_fetch_row($result);
                    $attr=1;
                    while($row != null){
                        echo "<tr><form action='update.php' method='POST'>";
                        echo "<td rowspan='2'><input type='hidden' name='id' value='$row[0]'>$row[0]</td>";
                        echo "<td rowspan='2'><input type=text name='pN' value= '$row[1]' ></td>";
                        echo "<td rowspan='2'>$row[2]</td>";
                        echo "<td rowspan='2'>$row[3]</td>";
                        echo "<td rowspan='2'><input type=text name='duty' value= '$row[4]' ></td>";
                        echo "<td  rowspan='2'><input type=text name='shift' value= '$row[5]' ></td>";
                        echo "<td  rowspan='2'>$row[6]</td>";
                        echo "<td  rowspan='2'><input type=text name='date' value= '$row[7]' ></td>";
                        echo "<td  rowspan='2'><input type=text name='dutytype' value= '$row[8]' ></td>";
                        echo "<td><button type=submit value='Update' name='Update'>Up</button></td>";
                        echo "</tr><tr><td colspan='9'><button type=submit value='Delete' name='Delete'>Del</button></td>";
                        echo "</form></tr>";
                    $row = mysqli_fetch_row($result); }
                ?>
            </table>
            <?php ?>
            <h3 style="font-size:20px; font-family: 'Arial'; color: green; display: inline-block;">Summary:</h3>
            <table>
                <tr>
                    <th rowspan="2">Total Soldiers</th>
                    <th colspan="4">Company Soldiers</th>
                </tr>
                <tr>
                    <th>Head Quarter</th>
                    <th>Operating</th>
                    <th>Radio</th>
                    <th>Radio Relay</th>
                </tr>
                <tr>
                <?php 
                        $sql5 = "SELECT COUNT(S_ID) as TOTAL from soldiers,dutyroster WHERE soldiers.ID=dutyroster.S_ID;";  
                        $res2 = mysqli_query($con,$sql5) or die(mysqli_error($con));
                        $row3 = mysqli_fetch_row($res2);
                        while($row3 !=null){
                           echo "<td>$row3[0]</td>";
                           $row3 = mysqli_fetch_row($res2);
                        }
                       if(isset($_GET['search'])){
                            $filter=$_GET['search'];
                            if($_GET['categories']=='any'){
                            $sql4="SELECT COUNT(S_ID) as TOTAL, COMPANY from soldiers,dutyroster WHERE soldiers.ID=dutyroster.S_ID AND CONCAT(PERSONAL_NUMBER,NAME,DATE,DUTY,COMPANY,SHIFT,RANK,DUTYTYPE) LIKE '%$filter%' GROUP BY COMPANY ORDER BY COMPANY; ";
                            }else{
                                $cat=$_GET['categories'];
                                $sql4 ="SELECT COUNT(S_ID) as TOTAL, COMPANY from soldiers,dutyroster WHERE soldiers.ID=dutyroster.S_ID AND $cat IN (SELECT $cat FROM soldiers,dutyroster WHERE $cat LIKE '%$filter%') GROUP BY COMPANY ORDER BY COMPANY; "; 
                            }
                        }else{
                        $sql4 = "SELECT COUNT(S_ID) as TOTAL, COMPANY from soldiers,dutyroster WHERE soldiers.ID=dutyroster.S_ID GROUP BY COMPANY ORDER BY COMPANY;";  
                        }
                        $res = mysqli_query($con,$sql4) or die(mysqli_error($con));
                        $row2 = mysqli_fetch_row($res);
                        $attr=1;
                        while($attr<5){
                            if(($row2[1]=='Head Quarter' && $attr==1)||($row2[1]=='Operating' && $attr==2)||($row2[1]=='Radio' && $attr==3)||($row2[1]=='Radio Relay' && $attr==4)){
                                echo "<td>$row2[0]</td>";
                                $row2 = mysqli_fetch_row($res);
                            }else{
                                echo "<td>N/A</td>";
                            }
                           $attr++;
                        }
                    ?>
                </tr>
            </table>
            <?php
                }
                if(isset($_SESSION['Page']) && $_SESSION['Page']=="Training Statistics"){
                    $pre="SELECT * from session WHERE TABLENAME='coursestat' AND ID='$id';";
                    $pre_res = mysqli_query($con,$pre) or die(mysqli_error($con));
                    $row = mysqli_fetch_row($pre_res);
                    while($row !=null){
                        $_SESSION['Page']='RESET';
                        $_POST['Page']="RESET";
                        $msg="Cannot Access Duty Roster: ".$row[0]." is working on it!";
                        echo "<script>alert('$msg');location.href='commanding.php';</script>";
                    }
                    $s2="INSERT into session (ID,TABLENAME) VALUES('$ssID','coursestat') ON DUPLICATE KEY UPDATE TABLENAME = 'coursestat';;";
                    mysqli_query($con, $s2);
                    
            ?>
                <div class="container-header">
                <form id="form1" method="POST" action="">
                <select name="Page">
                    <option value="Training Statistics" >Training Statistics</option>
                    <option value="Duty Roster" >Duty Roster</option>
                    <option value="Soldier Review" >Soldier Review</option>
                    <option value="Special Duty Roster">Special Event Duty</option>
                    <option value='Soldier Recruitment' >Soldier Recruitment</option>
                </select>
                <button type="submit" style="font-size:30px; background-color:transparent; border:0px"><i class="fa fa-table"></i></button>
                </form>
                <form action="" method="GET" style="height:30px; width:50%;">
                <input type="text" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>" name="search" placeholder="Search Data" style="border-radius:15px; border:2px;margin-top:5px; text-align:center; width:60%; height:100%; background-color:#F2F4F4 ;">
                <button type="submit"><i class="fa fa-search"></i></button>
                <select name="categories"  style="width: 60px; height: 20px; margin-top:10px; font-size:12px;">
                    <option value="any" >Any</option>
                    <option value="soldiers.PERSONAL_NUMBER" >Personal Number</option>
                    <option value="NAME" >Name</option>
                    <option value="RANK" >Rank</option>
                    <option value="COURSE" >Course</option>
                    <option value="COURSE.ID" >Course ID</option>
                    <option value="COMPANY" >Company</option>
                    <option value="REMARK" >Remarks</option>
                    <option value="DESCRIPTION" >Description</option>
                </select>
                </form>
                </div>
                <div style="background-color: #ABE3A4; margin-top:10px;">
                <?php 
                     echo "<table><tr><form action='insert.php' method='POST'>";
                     echo "<td><input type=text name='pN' placeholder='P.N.'></td>";
                     echo "<td><input type=text name='cid' placeholder='Course ID'></td>";
                     echo "<td><input type=text name='remark' placeholder='Remark'></td>";
                     echo "<td><input type=text name='description' placeholder='Description'></td>";
                     echo "<td><input type=text name='date' placeholder='Date'></td>";
                     echo "<td><button type=submit value='Insert' name='Insert'>New Course Result </button></td>";
                     echo "</form></tr></table>";
                ?>
                </div>
                 <table>
                <tr>
                    <th>Sl. No.</th>
                    <th>P.N.</th>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Course</th>
                    <th>Course ID</th>
                    <th>Remark</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Company</th>
                    <td>Action</td>
                </tr>
                <?php 
                    include("connection.php");
                    if(isset($_GET['search'])){
                        $filter=$_GET['search'];
                        if($_GET['categories']=='any'){
                        $sql="SELECT coursestat.ID,PERSONAL_NUMBER,soldiers.NAME,RANK,course.NAME,course.ID,REMARK,DESCRIPTION,DATE,COMPANY from soldiers,course,coursestat WHERE soldiers.ID=coursestat.S_ID AND course.ID=coursestat.C_ID AND CONCAT(coursestat.ID,PERSONAL_NUMBER,RANK,soldiers.NAME,course.NAME,course.ID,REMARK,DESCRIPTION,DATE,COMPANY) LIKE '%$filter%' ORDER BY coursestat.ID ASC; ";
                        }else{
                            $cat=$_GET['categories'];
                            $sql ="SELECT coursestat.ID,PERSONAL_NUMBER,soldiers.NAME,RANK,course.NAME,course.ID,REMARK,DESCRIPTION,DATE,COMPANY from soldiers,course,coursestat WHERE soldiers.ID=coursestat.S_ID AND course.ID=coursestat.C_ID AND $cat IN ((SELECT $cat FROM soldiers,course,coursestat WHERE $cat LIKE '%$filter%')) ORDER BY coursestat.ID ASC; "; 
                        }
                    }else{
                    $sql = "SELECT coursestat.ID,PERSONAL_NUMBER,soldiers.NAME,RANK,course.NAME,course.ID,REMARK,DESCRIPTION,DATE,COMPANY from soldiers,course,coursestat WHERE soldiers.ID=coursestat.S_ID AND course.ID=coursestat.C_ID ORDER BY coursestat.ID ASC;";  
                    }
                    $result = mysqli_query($con,$sql) or die(mysqli_error($con));
                    $row = mysqli_fetch_row($result);
                    $attr=1;
                    while($row != null){
                        echo "<tr><form action='update.php' method='POST'>";
                        echo "<td><input type='hidden' name='id' value='$row[0]'>$row[0]</td>";
                        echo "<td><input type=text name='pN' value= '$row[1]' ></td>";
                        echo "<td>$row[2]</td>";
                        echo "<td>$row[3]</td>";
                        echo "<td>$row[4]</td>";
                        echo "<td><input type=text name='cid' value= '$row[5]' ></td>";
                        echo "<td><input type=text name='remark' value= '$row[6]' ></td>";
                        echo "<td><input type=text name='description' value= '$row[7]' ></td>";
                        echo "<td><input type=text name='date' value= '$row[8]' ></td>";
                        echo "<td>$row[9]</td>";
                        echo "<td><button type=submit value='Update' name='Update'>Up</button>";
                        echo "</form></tr>";
                    $row = mysqli_fetch_row($result); }
                ?>
            </table>
            <?php } 
                if(isset($_SESSION['Page']) && $_SESSION['Page']=="Soldier Review"){
                    $pre="SELECT * from session WHERE TABLENAME='observation' AND ID!='$id';";
                    $pre_res = mysqli_query($con,$pre) or die(mysqli_error($con));
                    $row = mysqli_fetch_row($pre_res);
                    while($row !=null){
                        $_SESSION['Page']='RESET';
                        $_POST['Page']="RESET";
                        $msg="Cannot Access Duty Roster: ".$row[0]." is working on it!";
                        echo "<script>alert('$msg');location.href='commanding.php';</script>";
                    }
                    $s3="INSERT into session (ID,TABLENAME) VALUES('$ssID','observation') ON DUPLICATE KEY UPDATE TABLENAME = 'observation';";
                    mysqli_query($con, $s3);
            ?>
                <div class="container-header">
                <form id="form1" method="POST" action="">
                <select name="Page">
                    <option value="Soldier Review" >Soldier Review</option>
                    <option value="Training Statistics" >Training Statistics</option>
                    <option value="Duty Roster" >Duty Roster</option>
                    <option value="Special Duty Roster" >Speical Event Duty</option>
                    <option value='Soldier Recruitment' >Soldier Recruitment</option>
                </select>
                <button type="submit" style="font-size:30px; background-color:transparent; border:0px"><i class="fa fa-table"></i></button>
                </form>
                <form action="" method="GET" style="height:30px; width:50%;">
                <input type="text" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>" name="search" placeholder="Search Data" style="border-radius:15px; border:2px;margin-top:5px; text-align:center; width:60%; height:100%; background-color:#F2F4F4 ;">
                <button type="submit"><i class="fa fa-search"></i></button>
                <select name="categories"  style="width: 60px; height: 20px; margin-top:10px; font-size:12px;">
                    <option value="any" >Any</option>
                    <option value="soldiers.PERSONAL_NUMBER" >Personal Number</option>
                    <option value="observation.DATE" >Date</option>
                    <option value="RANK" >Rank</option>
                    <option value="NAME" >Name</option>
                    <option value="DISPOSAL" >disposal</option>
                    <option value="REMARK" >remark</option>
                    <option value="COMPANY" >company</option>
                </select>
                </form>
                </div>
                <div style="background-color: #ABE3A4; margin-top:10px;">
                <?php 
                    echo "<table><tr><form action='insert.php' method='POST'>";
                    echo "<td><input type=text name='pN' placeholder='P.N.'></td>";
                    echo "<td><input type=text name='type' placeholder='Offense Type'></td>";
                    echo "<td><input type=text name='remark' placeholder='Remark'></td>";
                    echo "<td><input type=text name='disposal' placeholder='Disposal'></td>";
                    echo "<td><input type=text name='date' placeholder='Date'></td>";
                    echo "<td><button type=submit value='Insert' name='Insert'>Insert New Review</button>";
                    echo "</form></tr></table>";
                ?>
                </div>
                <table>
                <tr>
                    <th>Sl. No.</th>
                    <th>P.N.</th>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Offense Type</th>
                    <th>Disposal</th>
                    <th>Remark</th>
                    <th>Date</th>
                    <th>Company</th>
                    <th>Action</th>
                </tr>
                <?php 
                    include("connection.php");
                    if(isset($_GET['search'])){
                        $filter=$_GET['search'];
                        if($_GET['categories']=='any'){
                        $sql ="SELECT observation.ID,PERSONAL_NUMBER,NAME,RANK,TYPE,DISPOSAL,REMARK,DATE,COMPANY from soldiers,observation WHERE soldiers.ID=observation.S_ID AND CONCAT(observation.ID,PERSONAL_NUMBER,NAME,RANK,TYPE,DISPOSAL,REMARK,DATE,COMPANY) LIKE '%$filter%' ORDER BY observation.ID ASC; ";
                        }else{
                            $cat=$_GET['categories'];
                            $sql ="SELECT observation.ID,PERSONAL_NUMBER,NAME,RANK,TYPE,DISPOSAL,REMARK,DATE,COMPANY from soldiers,observation WHERE soldiers.ID=observation.S_ID AND $cat IN ((SELECT $cat FROM soldiers,observation WHERE $cat LIKE '%$filter%')) ORDER BY observation.ID ASC; "; 
                        }
                    }else{
                        $sql ="SELECT observation.ID,PERSONAL_NUMBER,NAME,RANK,TYPE,DISPOSAL,REMARK,DATE,COMPANY from soldiers,observation WHERE soldiers.ID=observation.S_ID ORDER BY observation.ID ASC;";  
                    }
                    $result = mysqli_query($con,$sql) or die(mysqli_error($con));
                    $row = mysqli_fetch_row($result);
                    $attr=1;
                    while($row != null){
                        echo "<tr><form action='update.php' method='POST'>";
                        echo "<td rowspan='2'><input type='hidden' name='id' value='$row[0]'>$row[0]</td>";
                        echo "<td rowspan='2'><input type=text name='pN' value= '$row[1]' ></td>";
                        echo "<td rowspan='2'>$row[2]</td>";
                        echo "<td rowspan='2'>$row[3]</td>";
                        echo "<td rowspan='2'><input type=text name='type' value= '$row[4]' ></td>";
                        echo "<td rowspan='2'><input type=text name='disposal' value= '$row[5]' ></td>";
                        echo "<td rowspan='2'><input type=text name='remark' value= '$row[6]' ></td>";
                        echo "<td rowspan='2'><input type=text name='date' value= '$row[7]' ></td>";
                        echo "<td rowspan='2'>$row[8]</td>";
                        echo "<td><button type=submit value='Update' name='Update'>Up</button></td>";
                        echo "</tr><tr><td colspan='9'><button type=submit value='Delete' name='Delete'>Del</button></td>";
                        echo "</form></tr>";
                    $row = mysqli_fetch_row($result); }
                    ?>
                </table>
        <?php } 
            if(isset($_SESSION['Page']) && $_SESSION['Page']=="Special Duty Roster"){
                $pre="SELECT * from session WHERE TABLENAME='specialdutyroster' AND ID!='$id';";
                $pre_res = mysqli_query($con,$pre) or die(mysqli_error($con));
                $row = mysqli_fetch_row($pre_res);
                while($row !=null){
                    $_SESSION['Page']='RESET';
                    $_POST['Page']="RESET";
                    $msg="Cannot Access Duty Roster: ".$row[0]." is working on it!";
                    echo "<script>alert('$msg');location.href='commanding.php';</script>";
                }
                $s5="INSERT into session (ID,TABLENAME) VALUES('$ssID','specialdutyroster') ON DUPLICATE KEY UPDATE TABLENAME = 'specialdutyroster';";
                mysqli_query($con, $s5);
            ?>
            <div class="container-header">
            <form id="form1" method="POST" action="">
            <select name="Page" >
                <option value="Special Duty Roster" >Special Event Duty</option>
                <option value="Duty Roster" >Duty Roster</option>
                <option value="Training Statistics" >Training Statistics</option>
                <option value="Soldier Review" >Soldier Review</option>
                <option value='Soldier Recruitment' >Soldier Recruitment</option>
            </select>
            <button type="submit" style="font-size:30px; background-color:transparent; border:0px"><i class="fa fa-table"></i></button>
            </form>
            <form action="" method="GET" style="height:30px; width:60%;">
            <input type="text" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" name="search" placeholder="Search Data" style="border-radius:15px; border:2px;margin-top:5px; text-align:center; width:60%; height:100%; background-color:#F2F4F4 ;">
            <button type="submit"><i class="fa fa-search"></i></button>
            <select name="categories"  style="width: 60px; height: 20px; margin-top:10px; font-size:12px;">
                <option value="any" >Any</option>
                <option value="soldiers.PERSONAL_NUMBER" >Personal Number</option>
                <option value="NAME" >Name</option>
                <option value="RANK" >Rank</option>
                <option value="dutyroster.DATE" >Date</option>
                <option value="DUTY" >Duty</option>
                <option value="SHIFT" >Shift</option>
                <option value="DESCRIPTION" >Role</option>
                <option value="COMPANY" >Company</option>
            </select>
            </form>
            <form action="truncate.php" method="POST" style="height:30px;">
                <button type="submit" style="font-size:13px;color:red;height:100%;">Delete Special Event Roster</button>
            </form>
            </div>
            <div style="background-color: #ABE3A4; margin-top:10px;">
            <?php 
                 echo "<table><tr><form action='insert.php' method='POST'>";
                 echo "<td><input type=text name='pN' placeholder='P.N.'></td>";
                 echo "<td><input type=text name='duty' placeholder='Duty'></td>";
                 echo "<td><input type=text name='shift' placeholder='Shift'></td>";
                 echo "<td><input type=text name='dutytype' placeholder='Responsibility'></td>";
                 echo "<td><input type=text name='date' placeholder='Date'></td>";
                 echo "<td><button type=submit value='Insert' name='Insert'>Insert New Special Duty</button>";
                 echo "</form></tr></table>";
            ?>
            </div>
             <table>
            <tr>
                <th >Sl.</th>
                <th>P.N.</th>
                <th>Name</th>
                <th>Rank</th>
                <th>Duty</th>
                <th>Shift</th>
                <th>Company</th>
                <th>Date</th>
                <th>Role</th>
                <td>Action</td>
            </tr>
            <?php 
                include("connection.php");
                if(isset($_GET['search'])){
                    $filter=$_GET['search'];
                    if($_GET['categories']=='any'){
                    $sql="SELECT specialdutyroster.ID,PERSONAL_NUMBER,NAME,RANK,DUTY,SHIFT,COMPANY,DATE,DUTYTYPE from soldiers,specialdutyroster WHERE soldiers.ID=specialdutyroster.S_ID AND CONCAT(PERSONAL_NUMBER,NAME,DATE,DUTY,COMPANY,SHIFT,RANK,DUTYTYPE) LIKE '%$filter%' ORDER BY specialdutyroster.ID ASC; ";
                    }else{
                        $cat=$_GET['categories'];
                        $sql ="SELECT specialdutyroster.ID,PERSONAL_NUMBER,NAME,RANK,DUTY,SHIFT,COMPANY,DATE,DUTYTYPE from soldiers,specialdutyroster WHERE soldiers.ID=specialdutyroster.S_ID AND $cat IN (SELECT $cat FROM soldiers,dutyroster WHERE $cat LIKE '%$filter%') ORDER BY specialdutyroster.ID ASC; "; 
                    }
                }else{
                $sql = "SELECT specialdutyroster.ID,PERSONAL_NUMBER,NAME,RANK,DUTY,SHIFT,COMPANY,DATE,DUTYTYPE from soldiers,specialdutyroster WHERE soldiers.ID=specialdutyroster.S_ID ORDER BY specialdutyroster.ID ASC;";  
                }
                $result = mysqli_query($con,$sql) or die(mysqli_error($con));
                $row = mysqli_fetch_row($result);
                $attr=1;
                while($row != null){
                    echo "<tr><form action='update.php' method='POST'>";
                    echo "<td rowspan='2'><input type='hidden' name='id' value='$row[0]'>$row[0]</td>";
                    echo "<td rowspan='2'><input type=text name='pN' value= '$row[1]' ></td>";
                    echo "<td rowspan='2'>$row[2]</td>";
                    echo "<td rowspan='2'>$row[3]</td>";
                    echo "<td rowspan='2'><input type=text name='duty' value= '$row[4]' ></td>";
                    echo "<td  rowspan='2'><input type=text name='shift' value= '$row[5]' ></td>";
                    echo "<td  rowspan='2'>$row[6]</td>";
                    echo "<td  rowspan='2'><input type=text name='date' value= '$row[7]' ></td>";
                    echo "<td  rowspan='2'><input type=text name='dutytype' value= '$row[8]' ></td>";
                    echo "<td><button type=submit value='Update' name='Update'>Up</button></td>";
                    echo "</tr><tr><td colspan='9'><button type=submit value='Delete' name='Delete'>Del</button></td>";
                    echo "</form></tr>";
                $row = mysqli_fetch_row($result); }
                ?>
                <table>
                <tr>
                    <th rowspan="2">Total Soldiers</th>
                    <th colspan="4">Company Soldiers</th>
                </tr>
                <tr>
                    <th>Head Quarter</th>
                    <th>Operating</th>
                    <th>Radio</th>
                    <th>Radio Relay</th>
                </tr>
                <tr>
                <?php 
                        $sql6 = "SELECT COUNT(S_ID) as TOTAL from soldiers,specialdutyroster WHERE soldiers.ID=specialdutyroster.S_ID;";  
                        $res3 = mysqli_query($con,$sql6) or die(mysqli_error($con));
                        $row4 = mysqli_fetch_row($res3);
                        while($row4 !=null){
                           echo "<td>$row4[0]</td>";
                           $row4 = mysqli_fetch_row($res3);
                        }
                       if(isset($_GET['search'])){
                            $filter=$_GET['search'];
                            if($_GET['categories']=='any'){
                            $sql7="SELECT COUNT(S_ID) as TOTAL, COMPANY from soldiers,specialdutyroster WHERE soldiers.ID=specialdutyroster.S_ID AND CONCAT(PERSONAL_NUMBER,NAME,DATE,DUTY,COMPANY,SHIFT,RANK,DUTYTYPE) LIKE '%$filter%' GROUP BY COMPANY ORDER BY COMPANY; ";
                            }else{
                                $cat=$_GET['categories'];
                                $sql7 ="SELECT COUNT(S_ID) as TOTAL, COMPANY from soldiers,specialdutyroster WHERE soldiers.ID=specialdutyroster.S_ID AND $cat IN (SELECT $cat FROM soldiers,specialdutyroster WHERE $cat LIKE '%$filter%') GROUP BY COMPANY ORDER BY COMPANY; "; 
                            }
                        }else{
                        $sql7 = "SELECT COUNT(S_ID) as TOTAL, COMPANY from soldiers,specialdutyroster WHERE soldiers.ID=specialdutyroster.S_ID GROUP BY COMPANY ORDER BY COMPANY;";  
                        }
                        $res4 = mysqli_query($con,$sql7) or die(mysqli_error($con));
                        $row5 = mysqli_fetch_row($res4);
                        $attr=1;
                        while($attr<5){
                            if(($row5[1]=='Head Quarter' && $attr==1)||($row5[1]=='Operating' && $attr==2)||($row5[1]=='Radio' && $attr==3)||($row5[1]=='Radio Relay' && $attr==4)){
                                echo "<td>$row5[0]</td>";
                                $row5 = mysqli_fetch_row($res4);
                            }else{
                                echo"<td>N/A</td>";
                            }
                           $attr++;
                        }
                    ?>
                </tr>
            </table>
            <?php 
            }
            if(isset($_SESSION['Page']) && $_SESSION['Page']=="Soldier Recruitment"){
                $pre="SELECT * from session WHERE TABLENAME='soldiers' AND ID='$id';";
                $pre_res = mysqli_query($con,$pre) or die(mysqli_error($con));
                $row = mysqli_fetch_row($pre_res);
                while($row !=null){
                    $_SESSION['Page']='RESET';
                    $_POST['Page']="RESET";
                    $msg="Cannot Access Duty Roster: ".$row[0]." is working on it!";
                    echo "<script>alert('$msg');location.href='commanding.php';</script>";
                }
                $s4="INSERT into session (ID,TABLENAME) VALUES('$ssID','soldiers') ON DUPLICATE KEY UPDATE TABLENAME = 'soldiers';";
                mysqli_query($con, $s4);
            ?>
            <div class="container-header">
            <form id="form1" method="POST" action="">
            <select name="Page" >
                <option value='Soldier Recruitment' >Soldier Recruitment</option>
                <option value="Special Duty Roster" >Special Event Duty</option>
                <option value="Duty Roster" >Duty Roster</option>
                <option value="Training Statistics" >Training Statistics</option>
                <option value="Soldier Review" >Soldier Review</option>
            </select>
            <button type="submit" style="font-size:30px; background-color:transparent; border:0px"><i class="fa fa-table"></i></button>
            </form>
            <form action="" method="GET" style="height:30px; width:60%;">
            <input type="text" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" name="search" placeholder="Search Data" style="border-radius:15px; border:2px;margin-top:5px; text-align:center; width:60%; height:100%; background-color:#F2F4F4 ;">
            <button type="submit"><i class="fa fa-search"></i></button>
            <select name="categories"  style="width: 60px; height: 20px; margin-top:10px; font-size:12px;">
                <option value="any" >Any</option>
                <option value="soldiers.PERSONAL_NUMBER" >Personal Number</option>
                <option value="NAME" >Name</option>
                <option value="RANK" >Rank</option>
                <option value="dutyroster.DATE" >Date</option>
                <option value="DUTY" >Duty</option>
                <option value="SHIFT" >Shift</option>
                <option value="DESCRIPTION" >Role</option>
                <option value="COMPANY" >Company</option>
            </select>
            </form>
            </div>
            <div style="background-color: #ABE3A4; margin-top:10px; margin-left:0px; ">
            <?php 
                 echo "<table><tr><form action='insert.php' method='POST'>";
                 echo "<td><input type=text name='pN' placeholder='P.N.'></td>";
                 echo "<td><input type=text name='name' placeholder='Name'></td>";
                 echo "<td><input type=text name='rank' placeholder='Rank'></td>";
                 echo "<td><input type=text name='address' placeholder='Address'></td>";
                 echo "<td><input type=text name='phone' placeholder='Phone'></td>";
                 echo "<td><input type=text name='dob' placeholder='Date of Birth'></td>";
                 echo "<td><input type=text name='company' placeholder='Company'></td>";
                 echo "<td><button type=submit value='Insert' name='Insert'>Insert New Soldier</button>";
                 echo "</form></tr></table>";
            ?>
            </div>
             <table>
            <tr>
                <th >Sl.</th>
                <th>P.N.</th>
                <th>Name</th>
                <th>Rank</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Company</th>
            </tr>
            <?php 
                include("connection.php");
                if(isset($_GET['search'])){
                    $filter=$_GET['search'];
                    if($_GET['categories']=='any'){
                    $sql="SELECT * from soldiers WHERE CONCAT(PERSONAL_NUMBER,NAME,DATE,COMPANY,RANK,DOB,ADDRESS,ID,PHONE) LIKE '%$filter%' ORDER BY ID ASC; ";
                    }else{
                        $cat=$_GET['categories'];
                        $sql ="SELECT * from soldiers WHERE $cat IN (SELECT $cat FROM soldiers,dutyroster WHERE $cat LIKE '%$filter%') ORDER BY ID ASC; "; 
                    }
                }else{
                $sql = "SELECT * from soldiers;";  
                }
                $result = mysqli_query($con,$sql) or die(mysqli_error($con));
                $row = mysqli_fetch_row($result);
                $attr=1;
                while($row != null){
                    echo "<tr><form action='update.php' method='POST'>";
                    echo "<td rowspan='2'><input type='hidden' name='id' value='$row[0]'>$row[0]</td>";
                    echo "<td rowspan='2'>$row[6]</td>";
                    echo "<td rowspan='2'><input type=text name='name' value='$row[1]'></td>";
                    echo "<td rowspan='2'><input type=text name='rank' value='$row[2]'></td>";
                    echo "<td rowspan='2'><input type=text name='address' value= '$row[3]' ></td>";
                    echo "<td  rowspan='2'><input type=text name='phone' value= '$row[4]' ></td>";
                    echo "<td  rowspan='2'><input type=text name='dob' value= '$row[5]' ></td>";
                    echo "<td  rowspan='2'><input type=text name='company' value= '$row[8]' ></td>";
                    echo "<td><button type=submit value='Update' name='Update'>Up</button></td>";
                    echo "</tr><tr><td colspan='9'><button type=submit value='Delete' name='Delete'>Del</button></td>";
                    echo "</form></tr>";
                $row = mysqli_fetch_row($result); }
            }
            ?>
        </table>
    </div>
</body>
</html>