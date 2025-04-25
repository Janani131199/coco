<?php
include 'db.php';
session_start();

// Add item to cart with quantity handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_name'], $_POST['item_price'])) {
    $name  = $_POST['item_name'];
    $price = floatval($_POST['item_price']);

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] === $name) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'name' => $name,
            'price' => $price,
            'quantity' => 1
        ];
    }
}

// Handle checkout action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    if (!empty($_SESSION['cart'])) {
        $customer = $_SESSION['name'] ?? 'Guest';

        foreach ($_SESSION['cart'] as $item) {
            $name     = mysqli_real_escape_string($conn, $item['name']);
            $price    = mysqli_real_escape_string($conn, $item['price']);
            $quantity = mysqli_real_escape_string($conn, $item['quantity']);
            $cust     = mysqli_real_escape_string($conn, $customer);

            mysqli_query($conn, "INSERT INTO orders (customer_name, item_name, item_price, quantity) VALUES ('$cust', '$name', '$price', '$quantity')");
        }

        $_SESSION['last_order'] = $_SESSION['cart'];
        unset($_SESSION['cart']);
        echo "<script> window.location='payment.php';</script>";
        exit();
    } else {
        echo "<script>alert('Cart is empty.'); window.location='menu.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart - Coconut Shell</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .cart-section {
            max-width: 700px;
            margin: 40px auto;
            padding: 20px;
            background: #1a1a1a;
            border-radius: 12px;
            color: #fff;
        }
        .cart-section h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #444;
        }
        .cart-total {
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
        }
        .checkout-btn {
            background: #D38B5D;
            color: white;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header class="nav-bar">
    <div class="logo"><img src="images/logo.jpg" height="40"> <span>Coconut Shell</span></div>
    <nav class="nav-links">
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="tiffin.php">Tiffin</a>
        <a href="logout.php" style="color: red;">Logout</a>
    </nav>
</header>

<section class="cart-section">
    <h2>Your Cart</h2>
    <?php
    if (!empty($_SESSION['cart'])) {
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $qty = $item['quantity'] ?? 1;
            $subtotal = $item['price'] * $qty;
            echo "<div class='cart-item'>
                    <span>{$item['name']} × $qty</span>
                    <span>\$" . number_format($subtotal, 2) . "</span>
                  </div>";
            $total += $subtotal;
        }

        echo "
            <div class='cart-total'>Total: \$" . number_format($total, 2) . "</div>
            <form method='POST'>
                <input type='hidden' name='checkout' value='1'>
                <button class='checkout-btn' type='submit'>Proceed to Checkout</button>
            </form>
        ";
    } else {
        echo "<p>Your cart is empty.</p>";
    }
    ?>
</section>

</body>
</html>
