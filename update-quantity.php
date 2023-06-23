<?php
session_start();

// Verifică dacă ID-ul produsului și cantitatea sunt furnizate
if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $productId = $_POST['id'];
    $quantity = $_POST['quantity'];

    // Verifică dacă produsul există în coș
    if (isset($_SESSION['cart'][$productId])) {
        // Actualizează cantitatea produsului din coș
        $_SESSION['cart'][$productId]['quantity'] = $quantity;

        // Răspuns de succes
        echo "succes";
    } else {
        // Răspuns de eroare
        echo "Produsul nu a fost găsit în coș";
    }
} else {
    // Răspuns de eroare
    echo "Cerere nevalidă";
}
?>
