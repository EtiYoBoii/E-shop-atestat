<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>3DP SBRO</title>

</head>

<body>
  <header class="header">
    <div class="container">
      <h1>3DP SBRO</h1>
      <img src="3DP SBRO-1.png" alt="logo" class="logo">
      <nav class="navbar">
        <ul>
          <li><a href="index.php">Acasă</a></li>
          <li><a href="products.php">Produse</a></li>
          <li><a href="about.php">Despre</a></li>
          <li><a href="cart.php">Coș de cumpărături</a></li>
        </ul>
      </nav>
      <?php if (isset($_SESSION["user_id"])) : ?>
        <p>Salutare, <?php echo $_SESSION["username"]; ?>!</p>
        <p><a href="logout.php">Log out</a></p>
      <?php else : ?>
        <p><a href="login.php">Log in</a> or <a href="register.php">register</a> să începi cumpărarea.</p>
      <?php endif;
      ?>
    </div>
  </header>
</body>
<div class="container">
        <h2>Produse noi:</h2>

        <div class="product-list">
            <?php
            // Conexiunea la baza de date
            $host = 'localhost';
            $dbname = 'eshop';
            $username = 'admin';
            $password = '******';

            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

            try {
                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Obținerea produselor din baza de date
                $stmt = $pdo->query('SELECT * FROM products ORDER BY product_id DESC LIMIT 4');

                while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $productId = $product['product_id'];
                    $productName = $product['product_name'];
                    $description = $product['description'];
                    $price = $product['price'];
                    $imageUrl = $product['image_url'];

                    echo '<div class="product">';
                    echo '<img src="' . $imageUrl . '" alt="' . $productName . '">';
                    echo '<h3>' . $productName . '</h3>';
                    echo '<p>' . $description . '</p>';
                    echo '<p>Preț: ' . $price . ' lei</p>';
                    echo '<a href="add-to-cart.php?product_id=' . $productId . '" class="button">Adaugă în coș</a>';
                    echo '</div>';
                }
            } catch (PDOException $e) {
                echo 'Conexiune eșuată: ' . $e->getMessage();
            }

            // Închiderea conexiunii la baza de date
            $pdo = null;
            ?>
        </div>
    </div>

</html>
