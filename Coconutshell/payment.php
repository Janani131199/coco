<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_payment'])) {
    $customer_name = mysqli_real_escape_string($conn, $_SESSION['name'] ?? 'Guest');
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $card_number = $_POST['card_number'];
    $expiry = $_POST['expiry']; // You can store this if needed, not required here
    $last4 = substr($card_number, -4);
    $masked_card = "**** **** **** $last4";

    // Calculate cart total
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Generate unique payment ID
    $payment_id = uniqid('pay_');

    // Insert into database
    $sql = "INSERT INTO payments (payment_id, customer_name, address, amount, card_last4) 
            VALUES ('$payment_id', '$customer_name', '$address', '$total', '$masked_card')";

    if (mysqli_query($conn, $sql)) {
        unset($_SESSION['cart']);
        echo "<script>alert('Payment successful! Order placed.'); window.location='receipt.php?id=$payment_id';</script>";
    } else {
        echo "<script>alert('Error saving payment.'); window.location='payment.php';</script>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment - Coconut Shell</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .payment-form {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #1a1a1a;
            color: white;
            border-radius: 10px;
        }
        .payment-form input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
        }
        .payment-form button {
            background-color: #D38B5D;
            color: white;
            font-weight: bold;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="payment-form">
    <h2>Delivery & Payment Info</h2>
    <form method="POST" action="payment_rec.php">
        <label>Delivery Address</label>
        <textarea name="address" required></textarea>

        <label>Card Number</label>
        <input type="text" name="card_number" maxlength="16" required>

        <label>Expiry Date (MM/YY)</label>
        <input type="text" name="expiry" placeholder="MM/YY" pattern="^(0[1-9]|1[0-2])\/\d{2}$" required>

        <label>CVV</label>
        <input type="password" name="cvv" maxlength="3" required>

        <button type="submit" name="submit_payment">Pay Now</button>
    </form>
</div>

</body>
</html>
