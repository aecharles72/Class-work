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

if ( ! isset($_REQUEST['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

//load the profile in // question
$stmt = $pdo->prepare('SELECT * FROM profile WHERE profile_id = :prof AND user_id = :uid');
$stmt->execute(array( ':prof' => $_REQUEST['profile_id'], ':uid' => $_SESSION['user_id']));
$profile = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $profile === false ) {
  $_SESSION['error'] = "Could not load profile";
  header('Location: index.php');
  return;
}

if ( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])
      && isset($_POST['headline']) && isset($_POST['summary']) && isset($_POST['update']) ){
        $msg = validateProfile();
        if( is_string($msg)) {
          $_SESSION['error'] = $msg;
          header("Location: edit.php?profile_id= ". $_REQUEST['profile_id']);
          return;
        }
        //Validate position entries if present
        $msg = validatePos();
        if( is_string($msg)) {
          $_SESSION['error'] = $msg;
          header("Location: edit.php?profile_id=" . $_REQUEST['profile_id']);
          return;
        }

$stmt = $pdo->prepare('UPDATE profile SET
 first_name = :fn, last_name = :ln,
 email = :em, headline = :he, summary = :su
   WHERE profile_id = :pid AND user_id = :uid');
$stmt->execute(array(
  ':pid' => $_REQUEST['profile_id'],
  ':uid' => $_SESSION['user_id'],
  ':fn' => $_POST['first_name'],
  ':ln' => $_POST['last_name'],
  ':em' => $_POST['email'],
  ':he' => $_POST['headline'],
  ':su' => $_POST['summary'])
);


//Clear out the old position entries
$stmt = $pdo->prepare('DELETE FROM position WHERE profile_id = :pid');
$stmt->execute(array( ':pid' => $_REQUEST['profile_id']));

//Insert the position entries
$rank = 1;
for($i=1; $i<=9; $i++) {
  if (! isset($_POST['year'.$i])) continue;
  if (! isset($_POST['desc'.$i])) continue;
  $year = $_POST['year'.$i];
  $desc = $_POST['desc'.$i];

  $stmt = $pdo->prepare('INSERT INTO position (profile_id, rank, year, description) VALUES ( :pid, :rank, :year, :desc) ');
  $stmt->execute(array(
    ':pid' => $_REQUEST['profile_id'],
    ':rank' => $rank,
    ':year' => $year,
    ':desc' => $desc));
  $rank++;
  }
$_SESSION['success'] = 'Profile updated';
header( 'Location: index.php' );
return;
}
 //Load up the position rows

$positions = loadPos($pdo, $_REQUEST['profile_id']);

?>
<!DOCTYPE html>
<html>
<head>
<title>Drew Charles d1363829 Profile Add</title>
<?php require_once "head.php"; ?>
</head>

<body>
<div class="container">
<h1>Editing profile for <?= htmlentities($_SESSION['name']); ?></h1>
<?php
flashMessages();
  $stmt = $pdo->prepare("SELECT * FROM profile WHERE profile_id = :xyz");
  $stmt->execute(array(":xyz" => $_GET['profile_id']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index1.php' );
    return;
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
  <p>
  Position: <input type="submit" id="addPos" value="+">
  <div id="position_fields">
  </div>
  </p>
  <p>
  <input type="submit" name="update" value="Save">
  <input type="submit" name="cancel" value="Cancel">
  </p>
  </form>
  <script>
  countPos = 0;
  $(document).ready(function(){
    window.console && console.log('Document ready called');
    $('#addPos').click(function(event){
      event.preventDefault();
      if (countPos >= 9) {
        alert("Maximum of nine position entries exceeded");
        return;
      }
      countPos++;
      window.console && console.log("Adding position "+countPos);
      $('#position_fields').append(
        '<div id="position'+countPos+'"> \
        <p>Year: <input type="text" name="year'+countPos+'" value="" /> \
        <input type="button" value="-" \
        onclick="$(\'#position'+countPos+'\').remove();return false;"></p> \
        <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
        </div>');
    });
  });
  </script>
  </div>
  </body>
  </html>
