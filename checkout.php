<?php
session_start();
require_once 'config.php';

// Verifică dacă utilizatorul este autentificat
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Verifică dacă coșul este gol
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

// Procesează comanda
$user_id = $_SESSION["user_id"];
$total_price = 0;

// Obține detalii despre utilizator din baza de date
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Creează un înregistrare pentru comandă în baza de date
$stmt = mysqli_prepare($conn, "INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "id", $user_id, $total_price);
mysqli_stmt_execute($stmt);
$order_id = mysqli_insert_id($conn);

// Inserează produsele comenzii în baza de date
foreach ($_SESSION['cart'] as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $price = $item['price'];
    $subtotal = $price * $quantity;

    $stmt = mysqli_prepare($conn, "INSERT INTO order_items (order_id, product_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iiidd", $order_id, $product_id, $quantity, $price, $subtotal);
    mysqli_stmt_execute($stmt);

    $total_price += $subtotal;
}

// Actualizează prețul total al comenzii
$stmt = mysqli_prepare($conn, "UPDATE orders SET total_price = ? WHERE order_id = ?");
mysqli_stmt_bind_param($stmt, "di", $total_price, $order_id);
mysqli_stmt_execute($stmt);

// Golește coșul
unset($_SESSION['cart']);

// Trimite confirmarea prin email
$to = $user['email'];
$subject = 'Confirmare Comandă';
$message = "Dragă {$user['username']},\n\nÎți mulțumim pentru comanda efectuată. Numărul comenzii tale este {$order_id}.\n\nPreț Total: {$total_price}\n\n";
$headers = "From: davidgliga99@gmail.com";

// Decomentează linia de mai jos pentru a trimite emailul (asigură-te că înlocuiești adresa de email a expeditorului)
// mail($to, $subject, $message, $headers);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Finalizare Comandă</title>
</head>
<body>
    <h1>Finalizare Comandă</h1>
    <p>Îți mulțumim pentru comandă. Numărul comenzii tale este <?php echo $order_id; ?>.</p>
    <p>Preț Total: <?php echo $total_price; ?></p>
    <a href="products.php">Continuă cumpărăturile</a>
</body>
</html>
