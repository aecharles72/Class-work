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
  echo "<p>";
  print_r($fn." ".$ln);
  echo "</p>\n";
  echo "<p>";
  print_r($em);
  echo "</p>\n";
  echo "<p>";
  print_r($hl);
  echo "</p>\n";
  echo "<p>";
  print_r($su);
  echo "</p>\n";
  echo('<a href="index.php">Done</a>');

$stmt = $pdo->query("SELECT profile_id from profile");
while($row = $stmt->fetchall(PDO::FETCH_ASSOC)) {
  if($row === false){
    $_SESSION['error2'] = 'No rows found';
  }
}

?>
</div>
</body>
</html>
