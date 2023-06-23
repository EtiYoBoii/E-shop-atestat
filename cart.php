<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    
    <title>Coș de cumpărături</title>
    
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
</body>

<?php
session_start();
require_once 'config.php';


// Verifică dacă coșul este gol
if (empty($_SESSION['cart'])) {
    echo "Coșul este gol";
} else {
    // Afișează produsele din coș
    foreach ($_SESSION['cart'] as $productId => $item) {
        $productName = $item['product_name'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $subtotal = $price * $quantity;

        echo "Produs: $productName<br>";
        echo "Cantitate: <input type='number' value='$quantity' min='1' max='10' data-product-id='$productId' class='quantity-input'><br>";
        echo "Preț: $price<br>";
        echo "Subtotal: $subtotal<br>";
        echo "<button data-product-id='$productId' class='remove-button'>Șterge</button>";
        echo "<hr>";
    }

    // Butonul de checkout
    echo "<button id='checkout-button'>Finalizează comanda</button>";
}
echo "<a href='products.php' class='button'>Continuă cumpărăturile</a>";
?>


<script>
    // Evenimentul de click pe butonul de ștergere
    const removeButtons = document.querySelectorAll('.remove-button');
    removeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.dataset.productId;
            // Apelarea funcției removeProduct și transmiterea productId-ului
            removeProduct(productId);
        });
    });

    // Evenimentul de schimbare a cantității din input
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', () => {
            const productId = input.dataset.productId;
            const quantity = input.value;
            // Apelarea funcției updateQuantity și transmiterea productId-ului și cantității
            updateQuantity(productId, quantity);
        });
    });

    // Evenimentul de click pe butonul de checkout
    const checkoutButton = document.getElementById('checkout-button');
    checkoutButton.addEventListener('click', () => {
        // Redirecționarea către pagina de checkout
        window.location.href = 'checkout.php';
    });

    // Funcția de ștergere a unui produs din coș
    function removeProduct(productId) {
        // Trimite o cerere AJAX către server pentru a elimina produsul din coș
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'remove-from-cart.php');
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Reîncarcă pagina după ștergerea reușită
                location.reload();
            }
        };
        xhr.send(`id=${productId}`);
    }

    // Funcția de actualizare a cantității unui produs din coș
    function updateQuantity(productId, quantity) {
        // Trimite o cerere AJAX către server pentru a actualiza cantitatea produsului din coș
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update-quantity.php');
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Reîncarcă pagina după actualizarea reușită
                location.reload();
        }
    };
    xhr.send(`id=${productId}&quantity=${quantity}`);
}
</script>