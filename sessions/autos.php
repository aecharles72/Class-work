<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'drew', 'pass');
// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Demand a GET parameter
$failure = false;
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}
if ( isset($_POST['make']) ) {
  if ( strlen($_POST['make']) < 1){
    $failure = "Make is required";
  } else {
    $sql1 = "INSERT INTO autos (make) VALUES (:make)";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute(array(
          ':make' => $_POST['make']));
  }
}
if ( isset($_POST['year']) ) { //&& isset($_POST['mileage']) ){
  if ( is_numeric($_POST['year']) ){// elseif ( is_numeric($_POST['mileage']) ){
    $sql2 = "INSERT INTO autos (year) VALUES (:year)";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute(array(
            ':year' => ($_POST['year'])));
          //  ':mileage' => ($_POST['mileage'])));
  } else {
    $failure = "Mileage and year must be numeric";
  }
}
if ( isset($_POST['mileage']) ){ //&& isset($_POST['mileage']) ){
  if ( is_numeric($_POST['mileage']) ){// elseif ( is_numeric($_POST['mileage']) ){
    $sql3 = "INSERT INTO autos (mileage) VALUES (:mileage)";
    $stmt3 = $pdo->prepare($sql3);
    $stmt3->execute(array(
            ':mileage' => ($_POST['mileage'])));
          //  ':mileage' => ($_POST['mileage'])));
  } else {
    $failure = "Mileage and year must be numeric";
  }
}
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
  // Note triple not equals and think how badly double
  // not equals would work here...
  if ( $failure !== false ) {
      // Look closely at the use of single and double quotes
      echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
  }
  ?>
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<p><input type="submit" value="Add">
<input type="submit" name="logout" value="Logout"></p>
</form>

<h2>Automobiles</h2>
<ul>
<p>
<?php
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
    echo "<li>";
    print_r(implode(" ",$row));
    echo "</li>\n";
}
?>
</ul>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>
