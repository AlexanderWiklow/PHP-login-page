<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Logged in page</title>
</head>
<body>
  <?php
  session_start(); // this is a php function that starts or resumes a session. It must be called before any output is generated. Cookies are used to store the session ID on the client side. The session ID is used to retrieve the session data on the server side.

  // Check if the user is authenticated, otherwise redirect to the login page
  if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    header('Location: loginForm.html');
    exit;
  }

  // Retrieve the username from the session
  $username = $_SESSION['name'];
  ?>

  <h1>Welcome, <?php echo htmlentities($username); ?>! You are now logged in.</h1>

</body>
</html>
