<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    
    <title>Produse</title>
    
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>3DP SBRO</h1>
            <nav class="navbar">
                <ul>
                <li><a href="index.php">Acasă</a></li>
				<li><a href="products.php">Produse</a></li>
				<li><a href="about.php">Despre</a></li>
                <li><a href="cart.php">Coș de cumpărături</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <h2>Produse</h2>

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
                $stmt = $pdo->query('SELECT * FROM products');

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

    <footer class="footer">
        <div class="container">
            <p>&copy; 2023 3DP SBRO. Toate drepturile rezervate.</p>
        </div>
    </footer>
</body>
</html>
