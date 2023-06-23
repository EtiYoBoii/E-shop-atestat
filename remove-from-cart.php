<?php
session_start();

// Verifică dacă ID-ul produsului este furnizat
if (isset($_POST['id'])) {
    $productId = $_POST['id'];

    // Verifică dacă produsul există în coș
    if (isset($_SESSION['cart'][$productId])) {
        // Elimină produsul din coș
        unset($_SESSION['cart'][$productId]);

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