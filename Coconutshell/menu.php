<?php
session_start();
include 'db.php';

// Handle cart addition with success message
if (isset($_GET['add']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['item_name'];
    $price = $_POST['item_price'];

    // Check if item already exists in cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] === $name) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = [
            'name' => $name,
            'price' => $price,
            'quantity' => 1
        ];
    }

    $_SESSION['message'] = "$name added to cart successfully!";
    header("Location: menu.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu - Coconut Shell Thunder Bay</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        .success-message {
            background: #28a745;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            margin: 10px auto;
            max-width: 600px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<header class="nav-bar">
    <div class="logo">
        <a href="userhome.php">
            <img src="images/logo.jpg" alt="Coconut Shell"/>
            <span>Coconut Shell</span>
        </a>
    </div>
    <nav class="nav-links">
        <a href="index.php">Home</a>
        <a href="menu.php" class="active">Menu</a>
        <a href="tiffin.php">Tiffin</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <?php
        $cart_count = 0;
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $cart_count += $item['quantity'];
            }
        }
        ?>
        <a href="order.php" class="cart-link">🛒 Cart (<?= $cart_count ?>)</a>
    </nav>
</header>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="success-message">
        <?= $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<?php
function loadMenuSection($conn, $title, $category) {
    $query = "SELECT * FROM menu WHERE category = '$category'";
    $result = mysqli_query($conn, $query);

    echo "<section class='menu-section'>";
    echo "<h2>" . htmlspecialchars($title) . "</h2>";
    echo "<div class='menu-grid'>";

    while ($item = mysqli_fetch_assoc($result)) {
        echo "<form method='POST' action='menu.php?add=true' class='menu-grid-item'>";
        echo "<img src='data:" . $item['image_type'] . ";base64," . base64_encode($item['image']) . "' alt='" . htmlspecialchars($item['name']) . "' />";
        echo "<h3>" . htmlspecialchars($item['name']) . "</h3>";
        echo "<div class='price-add'>";
        echo "<span>$" . number_format($item['price'], 2) . "</span>";
        echo "<input type='hidden' name='item_name' value='" . htmlspecialchars($item['name']) . "'>";
        echo "<input type='hidden' name='item_price' value='" . $item['price'] . "'>";
        echo "<button type='submit'>+</button>";
        echo "</div>";
        echo "</form>";
    }

    echo "</div></section>";
}

loadMenuSection($conn, 'Starters', 'starter');
loadMenuSection($conn, 'Main Course', 'main');
loadMenuSection($conn, 'Specials', 'special');
?>

</body>
</html>
