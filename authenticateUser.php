<?php
session_start(); // this is a php function that starts or resumes a session. It must be called before any output is generated. Cookies are used to store the session ID on the client side. The session ID is used to retrieve the session data on the server side.
require_once 'loginMySQL.php'; // this file contains the variables $host, $data, $user, $pass, $chrs, $attr, $opts and $pdo. It also contains the try-catch block that creates a PDO object and stores it in the variable $pdo.

// this block of code is executed if the user has submitted the login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Check if the username exists in the database
  try {
    $pdo = new PDO($attr, $user, $pass, $opts);
  } catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
  }

  // Prepare a SELECT statement to retrieve the user's password
  $query = "SELECT * FROM users WHERE name = ?";
  $stmt = $pdo->prepare($query); // prepare() returns a PDOStatement object. Prepare is safe against SQL injections.
  $stmt->execute([$username]);

  // Check if a row was returned
  if (!$stmt->rowCount()) {
    die("User not found");
  }

  $row = $stmt->fetch();
  $un = $row['name'];
  $pw = $row['password'];

  if (password_verify($password, $pw)) {
    // Set a session variable to indicate successful login
    $_SESSION['authenticated'] = true;
    $_SESSION['name'] = $un;

    // Redirect to the desired page
    header('Location: loggedInPage.php');
    exit; // Important to exit after the redirect
  } else {
    die("Invalid username/password combination");
  }
}
?>

