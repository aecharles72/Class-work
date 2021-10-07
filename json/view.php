<?php
require_once "pdo.php";
session_start();
if (! isset($_SESSION['user_id']) ) {
  die("ACCESS DENIED");
}
?>
<html>
<head>
<title>Drew Charles d1363829 Profile Database</title>
</head>
<h1>Andrew Charles Profile Database</h1>
<script type="text/javascript" src="jquery.min.js">
</script>
<body>
<div class="container">
<?php

$stmt = $pdo->prepare("SELECT * FROM profile WHERE profile_id = :abc");
$stmt->execute(array(":abc" => $_GET['profile_id']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $fn = htmlentities($row['first_name']);
  $ln = htmlentities($row['last_name']);
  $hl = htmlentities($row['headline']);
  $em = htmlentities($row['email']);
  $su = htmlentities($row['summary']);
  echo "<p>Name:";
  print_r($fn." ".$ln);
  echo "</p>\n";
  echo "<p>Email:";
  print_r($em);
  echo "</p>\n";
  echo "<p>Headline:";
  print_r($hl);
  echo "</p>\n";
  echo "<p>Summary:";
  print_r($su);
  echo "</p>\n";
  ?>
<div id="positions">
</div>
<?php
$stmt = $pdo->prepare("SELECT * FROM position WHERE profile_id = :abc");
$stmt->execute(array(":abc" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$yr = htmlentities($row['year']);
$de = htmlentities($row['description']);
  echo "<p>Year:";
  print_r($yr);
  echo "</p>\n";
  echo "<p>Desc:";
  print_r($de);
  echo "</p>\n";

$stmt = $pdo->prepare('SELECT year, name FROM education JOIN institution
    ON education.institution_id = institution.institution_id WHERE profile_id = :prof ORDER BY rank');
$stmt->execute(array( ':prof' => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$y = htmlentities($row['year']);
$n = htmlentities($row['name']);
  echo "<p>Year Attended:";
  print_r($y);
  echo "</p>\n";
  echo "<p>School:";
  print_r($n);
  echo "</p>\n";
  echo('<a href="index.php">Done</a>');
?>
</div>
</body>
</html>
