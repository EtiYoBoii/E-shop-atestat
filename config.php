<?php
// Configurație bază de date
$servername = "localhost";
$username = "admin";
$password = "******";
$dbname = "eshop";

// Crearea conecțiunii cu baza de date  
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificare conecțiune
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
