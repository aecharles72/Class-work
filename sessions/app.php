<?php
  session_start();
?>
<html>
<head>
</head>
<body style ="font=family; sans-serif;">
<h1>Cool Apllication</h1>
<?php
  if ( isset($_SESSION["success"]) ) {
    echo('<p styles="color:green">'.$_SESSION["success"]."<?p>\n")
    unset($_SESSION["success"]);
  }
// check if we are logged in
  if ( ! ISSET($_SESSION["account"]) ) { ?>
      <p>Please <a href="login.php">Log In</a> to start.</p>
  <?php } else { ?>
      <p> This is where a cool application wouold be.</p>
      <p> Please <a href="logout.php">Log Out</a> whend youa re done.<
      <?php } ?>
</body>
</html>
