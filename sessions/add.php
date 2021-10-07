<?php
require_once "pdo.php";
session_start();
// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}


$make = htmlentities($_POST['make']);
$year = $_POST['year'];
$mileage = $_POST['mileage'];

// Dump variable contents
// var_dump($make);

if (isset($make) && isset($year) && isset($mileage) ){
  if ( strlen($make) < 1 ) {
    $_SESSION["error"] = "Make is required";
    header( 'Location: add.php' ) ;
    return;
  } else if ( is_numeric($_POST['year']) === false || is_numeric($_POST['mileage']) === false ) {
    $_SESSION["error"] = "Mileage and year must be numeric";
    header( 'Location: add.php' ) ;
    return;
  }
 else {
  $sql = "INSERT INTO autos (make, year, mileage) VALUES (:make, :year, :mileage)";
  $stmt1 = $pdo->prepare($sql);
  $stmt1->execute(array(
    ':make' => $make,
    ':year' => $year,
    ':mileage' => $mileage));
  }
}

?>
<?php
require_once "pdo.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Andrew Charles Automobile Tracker</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Tracking Autos for <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="e097888fa08c8f83818c888f9394">[email&#160;protected]</a></h1>
<form method="post">
<?php
if ( isset($_SESSION['error']) ) {
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
    }
if (  isset($_POST['logout']) ) {
  header('Location: index.php');
  return;
    }
?>
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<?php
if ( isset($_POST['add']) ) {
    header('Location: view.php');
    return;
}
?>
<p><input type="submit" name="add" value="Add">
  <input type="submit" name="logout" value="Log Out"></p>
</form>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>
