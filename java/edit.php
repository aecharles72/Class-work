<?php
require_once "pdo.php";
require_once "utils.php";
session_start();

if (! isset($_SESSION['user_id']) ) {
  die("ACCESS DENIED");
}

if ( isset($_POST['cancel']) ){
  header('Location: index.php');
  return;
}



if ( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])
      && isset($_POST['headline']) && isset($_POST['summary']) && isset($_POST['update']) ){
  if ( strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) <1 || strlen($_POST['email']) <1 ||
   strlen($_POST['headline']) <1 || strlen($_POST['summary']) <1) {
     $_SESSION['error'] = 'Missing data';
     header("Location: edit.php?profile_id=".$_POST['profile_id']);
     return;
}
if (strpos($_POST['email'], '@') === false) {
  $_SESSION["error"] = "Email address must contain @";
  header('Location: edit.php');
}
$sql = "UPDATE profile SET
 first_name = :fn, last_name = :ln,
 email = :em, headline = :he, summary = :su, profile_id = :profile_id
   WHERE profile_id = :profile_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
  ':fn' => $_POST['first_name'],
  ':ln' => $_POST['last_name'],
  ':em' => $_POST['email'],
  ':he' => $_POST['headline'],
  ':su' => $_POST['summary'],
  ':profile_id' => $_POST['profile_id']));
  $_SESSION['success'] = 'Record updated';
  header( 'Location: index.php' );
  return;
}
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Andrew Charles Profile Add</title>
<!-- bootstrap.php - this is HTML -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
    crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Adding Profile for UMSI</h1>
<?php
if (isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
  }
  $stmt = $pdo->prepare("SELECT * FROM profile WHERE profile_id = :xyz");
  $stmt->execute(array(":xyz" => $_GET['profile_id']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index1.php' );
    return;
  }
  if ( isset($_SESSION['error']) ) {
      echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
      unset($_SESSION['error']);
  }
  $f = htmlentities($row['first_name']);
  $l = htmlentities($row['last_name']);
  $e = htmlentities($row['email']);
  $h = htmlentities($row['headline']);
  $s = htmlentities($row['summary']);
  $profile_id = $row['profile_id'];
?>
<form method="post">
  <p>First Name:<input type ="text" name="first_name" size = "60" value="<?= $f ?>"></p>
  <p>Last Name:<input type ="text" name="last_name" size = "60" value="<?= $l ?>"></p>
  <p>Email:<input type ="text" name="email" size = "30" value="<?= $e ?>"></p>
  <p>Headline:<input type ="text" name="headline" size = "80" value="<?= $h ?>"></p>
  <p>Summary:<input type ="text" name="summary" size = "80" rows="8" cols="80" value="<?= $s ?>"></p>
  <input type="hidden" name="profile_id" value="<?= $profile_id ?>">
  <p><input type="submit" name="update" value="Save"/>
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</div>
</body>
</html>
