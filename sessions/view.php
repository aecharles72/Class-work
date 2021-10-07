<?php
require_once "pdo.php";
session_start();
if ( ! isset($_SESSION['email']) ) {
    die('Not logged in');
}
?>
<html>
<head>
<title>Andrew Charles Automobile Tracker</title>
<h2>Automobiles</h2>
</head>
<body>
<ul>
<p>
<?php
require_once "pdo.php";
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
    echo "<li>";
    print_r(implode(" ",$row));
    echo "</li>\n";
}
?>
<a href="add.php" name="Add">Add New</a> | <a href="logout.php" name="Logout" id="logout">Logout</a>
</ul>
</body>
</html>
