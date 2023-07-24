<?php
session_start();

$users = array(
  'user1' => password_hash('password1', PASSWORD_DEFAULT),
  'user2' => password_hash('password2', PASSWORD_DEFAULT),
  'user3' => password_hash('password3', PASSWORD_DEFAULT),
  // add more users as needed
);

if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (isset($users[$username]) && password_verify($password, $users[$username])) {
    $_SESSION['username'] = $username;
    $_SESSION['message'] = "You are now logged in as $username";
    header('Location: bankApp.php'); // replace with your file name
  } else {
    $_SESSION['message'] = "Invalid username or password.";
    header('Location: login.php');
  }
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="bankApp.css">
</head>
<body>
  <?php
  if (isset($_SESSION['message'])) {
    echo "<div id='message'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']);
  }
  ?>
  <form method="post" action="login.php">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br>
    <input type="submit" value="Login">
  </form>
</body>
</html>
