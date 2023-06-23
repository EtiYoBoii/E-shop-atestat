<?php
session_start();

if (isset($_SESSION["user_id"])) {
  header("Location: index.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Database connection
  $servername = "localhost";
  $username = "admin";
  $password = "******";
  $dbname = "eshop";
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Get user input
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);

  // Check if user exists
  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $sql);
  $user = mysqli_fetch_assoc($result);

  if ($user) {
    $_SESSION["user_id"] = $user["user_id"];
    $_SESSION["username"] = $user["username"];
    header("Location: index.php");
    exit;
  } else {
    $error_message = "Invalid username or password.";
  }

  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - 3DP SBRO</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

  <h1>Login</h1>

  <?php if (isset($error_message)): ?>
    <p><?php echo $error_message; ?></p>
  <?php endif; ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <br>
    <button type="submit">Log in</button>
  </form>

  <p>Don't have an account? <a href="register.php">Register</a> now.</p>

</body>
</html>
