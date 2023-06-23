<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["product_id"])) {
    $product_id = $_GET["product_id"];
    $user_id = $_SESSION["user_id"];

    // Verică dacă produsul există
    $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE product_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        die("Produsul nu a fost găsit.");
    }

    // Adaugă produsul în coșul de cumpărături
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = array(
            'product_id' => $product_id,
            'product_name' => $product['product_name'],
            'quantity' => 1,
            'price' => $product['price']
        );
    }

    header("Location: cart.php");
    exit;
} else {
    echo "Id-ul produsului nu este valabil.";
}

mysqli_close($conn);
?>