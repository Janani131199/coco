<?php
session_start();
include 'db.php';

if (!empty($_SESSION['cart'])) {
    $customer = $_SESSION['name'] ?? 'Guest';

    foreach ($_SESSION['cart'] as $item) {
        $name = mysqli_real_escape_string($conn, $item['name']);
        $price = mysqli_real_escape_string($conn, $item['price']);
        $cust = mysqli_real_escape_string($conn, $customer);

        mysqli_query($conn, "INSERT INTO orders (customer_name, item_name, item_price) VALUES ('$cust', '$name', '$price')");
    }

    unset($_SESSION['cart']);
    echo "<script>alert('Order placed successfully!'); window.location='menu.php';</script>";
} else {
    echo "<script>alert('Cart is empty!'); window.location='menu.php';</script>";
}
