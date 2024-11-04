<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="icon" href="img/enblem.png">
    <title>Signals Portal</title>
</head>
<?php 
    session_abort();  
?>
<body >
    <div class="header">
        <img src="img/enblem.png" onclick="location.href='index.php'">
        <text>Duty Roster & Course Management Portal</text>
        <a href="help.php"> Help</a>
    </div>

    <div class="container">
        <div class="box">
          <span class="borderLine"></span>
          <form name="f1" action="authentication.php" method="post">
            <h2>Log in</h2>
            <div class="inputBox" name="input1">
              <input type="pN" id="pN" required="required" name="pN"/>
              <span>Username</span>
              <i></i>
            </div>
            <div class="inputBox" name="input2">
              <input type="password" id="password" required="required" name="password" />
              <span>Password</span>
              <i></i>
            </div>
            <input type="submit" id="btn" value="Login" name="Login"/>
          </form>
        </div>
      </div>
  
</body>
</html>