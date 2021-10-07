<?php
session_start();
 if(! isset($_SESSION['name'])){
   die("ACCESS DENIED");
 }
require_once "pdo.php";

if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) {
  if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
      $_SESSION['error'] = 'All fields are required';
      header("Location: add.php");
      return;
  }

  if ( is_numeric($_POST['year']) === false || is_numeric($_POST['mileage']) === false)  {
      $_SESSION['error'] = 'Year must be an integer';
      header("Location: add.php");
      return;
  }

  $sql = "INSERT INTO autos (make, model, year, mileage) VALUES (:make, :model, :year, :mileage)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':make' => $_POST['make'],
    ':model' => $_POST['model'],
    ':year' => $_POST['year'],
    ':mileage' => $_POST['mileage']));
    $_SESSION['success'] = 'Record Added';
    header( 'Location: index2.php');
    return;
}
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success2']) ) {
    echo '<p style="color:green">'.$_SESSION['success2']."</p>\n";
    unset($_SESSION['success2']);
}
?>
<html>
<head>
<title>Andrew Charles Automobile Tracker</title>
</head>
<body>
<div class="container">

<p>Add A New Car</p>
<form method="post">
<p>Make:<input type="text" name="make"></p>
<p>Model:<input type="text" name="model"></p>
<p>Year:<input type="text" name="year"></p>
<p>Mileage:<input type="text" name="mileage"></p>
<p><input type="submit" value="Add New Entry">/
<a href="index.php">Logout</a></p>
</form>
</div>
</body>
</html>
