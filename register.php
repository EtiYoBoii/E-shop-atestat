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
  $email = mysqli_real_escape_string($conn, $_POST["email"]);
  $address = mysqli_real_escape_string($conn, $_POST["address"]);

  // Check if username is taken
  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $error_message = "Username already taken.";
  } else {
    // Insert user into database
    $sql = "INSERT INTO users (username, password, email, address) VALUES ('$username', '$password', '$email', '$address')";
if (mysqli_query($conn, $sql)) {
  $_SESSION["user_id"] = mysqli_insert_id($conn);
  $_SESSION["username"] = $username;
  header("Location: index.php");
  exit;
} else {
  $error_message = "Error creating account.";
}

}

mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register - 3DP SBRO</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <h1>Register</h1>
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
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <br>
    <label for="address">Address:</label>
    <textarea name="address" required></textarea>
    <br>
    <button type="submit">Register</button>
  </form>
  <p>Already have an account? <a href="login.php">Log in</a> now.</p>
</body>
</html>
