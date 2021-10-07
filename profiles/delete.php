<?php
require_once "pdo.php";
session_start();
if (! isset($_SESSION['user_id']) ) {
  die("ACCESS DENIED");
}
if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
$sql = "DELETE FROM profile WHERE profile_id = :zip";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':zip' => $_POST['profile_id']));
$_SESSION['success'] = 'Record deleted';
header('Location: index.php');
return;
}

if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing user_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT first_name, profile_id FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
  $_SESSION['error'] = 'No rows found';
  header(' Location: index.php');
  return;
}
if (isset($_POST['cancel'])) {
  header('Location: index.php');
  return;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Drew Charles d1363829 Profile Add</title>
<?php require_once "head.php"; ?>
</head>

<body>
<div class="container">
  <p>Confirm: Deleting <?= htmlentities($row['first_name']) ?></p>

  <form method="post">
  <input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>">
  <input type="submit" value="Delete" name="delete">
  <input type="submit" value="Cancel" name="cancel">

</form>
</div>
</body>
</html>
