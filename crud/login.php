<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123
// Check to see if we have some POST data, if we do process it
if (isset($_POST['email']) && isset($_POST['pass']) ) {
    $pos = strpos($_POST['email'], '@');
    if ( strlen($_POST['email']) < 1 || $pos === false) {
      $_SESSION["error"] = "User name and password are required";
      header( 'Location: login.php' ) ;
      return;
    } else {if (strlen($_POST['pass']) <1) {
      $_SESSION["error"] = "Incorrect password.";
      header( 'Location: login.php' ) ;
      return;
        } else {
          $check = hash('md5', $salt.$_POST['pass']);
          if ( $check == $stored_hash ) {
              // Redirect the browser to game.php
              $_SESSION['name'] = $_POST['email'];
              $_SESSION['success'] = "Logged in.";
              header("Location: index2.php?name=".urlencode($_POST['who']));
              return;
        } else {
          $_SESSION["error"] = "Incorrect password.";
          header( 'Location: login.php' ) ;
          return;
      }
    }
  }
}

// if ( isset($_POST['email']) && isset($_POST['password'])  ) {
//    $sql = "SELECT email FROM users
//        WHERE email = :em AND password = :pw";

//    $stmt = $pdo->prepare($sql);
//    $stmt->execute(array(
//        ':em' => $_POST['email'],
//        ':pw' => $_POST['password']));
//    $row = $stmt->fetch(PDO::FETCH_ASSOC);

//   if ( $row === FALSE ) {
//      echo "<h1>Login incorrect.</h1>\n";
//   } else {
//     header("Location: autos.php?name=".urlencode($_POST['email']));
//   return;
//      echo "<p>Login success.</p>\n";
//   }
//}
?>
<!DOCTYPE html>
<html>
<head>

<title>Andrew Charles Automobile Tracker</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo('<p style="color:green">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>
<form method="POST">
<label for="who">User Name</label>
<input type="text" name="email" id="email"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
</div>
</body>
</html>
