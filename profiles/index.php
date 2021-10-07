<?php
require_once "pdo.php";
require_once "utils.php";
session_start();

?>
<html>
<head>
<title> Drew Charles d1363829 Profile Database</title>
<?php require_once "head.php"; ?>
</head>

<h1>Andrew Charles Profile Database</h1>
<body>
<div class="container">
<?php
flashMessages();

echo('<table border="1">'."\n");
echo"<tr><td>Name</td><td>Headline</td><td>";
$stmt = $pdo->query("SELECT first_name, last_name, headline, profile_id FROM profile");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
  $fn = htmlentities($row['first_name']);
  $ln = htmlentities($row['last_name']);
  echo "<tr><td>";
  echo ('<a href="view.php?profile_id='.$row['profile_id'].'">'.$fn." ".$ln.'</a>');
  echo "</td><td>";
  echo(htmlentities($row['headline']));
  echo "</td><td>";
  if (isset($_SESSION['user_id'])) {
    echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> /');
    echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
  }
  echo("</td></tr>\n");
}
$stmt = $pdo->query("SELECT profile_id from profile");
while($row = $stmt->fetchall(PDO::FETCH_ASSOC)) {
  if($row === false){
    $_SESSION['error2'] = 'No rows found';
  }
}
?>

<?php
if (isset($_SESSION['user_id'])) {
  echo "<p><a href='logout.php'>Logout</a></p>";
} else {
  echo "<p><a href='login.php'>Please log in</a></p>";
}
?>

<p><a href="add.php">Add New Entry</a></p>


<p>
<b>Note:</b> Your implementation should retain data across multiple
logout/login sessions.  This sample implementation clears all its
data periodically - which you should not do in your implementation.
</p>
</div>
</body>
</html>
