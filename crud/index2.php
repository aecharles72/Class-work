<?php
require_once "pdo.php";
session_start();

?>
<html>
<head>

<title>Andrew Charles Automobile Tracker</title>
</head>
<h1>Andrew Charles Automobile Tracker</h1>
<body>
<div class="container">
<?php
if (isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if (isset($_SESSION['error2']) ) {
    echo '<p style="color:red">'.$_SESSION['error2']."</p>\n";
    unset($_SESSION['error2']);
}

if (isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
echo('<table border="1">'."\n");
$stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
  echo "<tr><td>";
  echo(htmlentities($row['make']));
  echo "</td><td>";
  echo(htmlentities($row['model']));
  echo "</td><td>";
  echo(htmlentities($row['year']));
  echo "</td><td>";
  echo(htmlentities($row['mileage']));
  echo "</td><td>";
  echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> /');
  echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
  echo("</td></tr>\n");
}
$stmt = $pdo->query("SELECT autos_id from autos");
while( $row = $stmt->fetchall(PDO::FETCH_ASSOC)) {
  if($row === false){
    $_SESSION['error2'] = 'No rows found';
  }
}
?>
</table>
<a href="add.php">Add New Entry</a>/<a href="logout.php">Log Out</a>
</form>
</div>
</body>
</html>
