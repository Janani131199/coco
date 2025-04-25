<?php
session_start();
include 'db.php';


if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request'); window.location='index.php';</script>";
    exit;
}

$payment_id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM payments WHERE payment_id = '$payment_id' LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<script>alert('Payment not found'); window.location='index.php';</script>";
    exit;
}

$payment = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Receipt - Coconut Shell</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .receipt-box {
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            background: #1a1a1a;
            color: white;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(255,255,255,0.1);
        }
        .receipt-box h2 {
            color: #ffcc70;
        }
        .receipt-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        .thank-you {
            margin-top: 20px;
            font-weight: bold;
            color: #90ee90;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="receipt-box">
    <h2>Payment Successful 🎉</h2>
    <div class="receipt-row">
        <strong>Payment ID:</strong>
        <span><?= $payment['payment_id'] ?></span>
    </div>
    <div class="receipt-row">
        <strong>Customer Name:</strong>
        <span><?= htmlspecialchars($payment['customer_name']) ?></span>
    </div>
    <div class="receipt-row">
        <strong>Amount Paid:</strong>
        <span>$<?= number_format($payment['amount'], 2) ?></span>
    </div>
    <div class="receipt-row">
        <strong>Card:</strong>
        <span><?= $payment['card_last4'] ?></span>
    </div>
    <div class="receipt-row">
        <strong>Delivered To:</strong>
        <span><?= htmlspecialchars($payment['address']) ?></span>
    </div>
    <div class="receipt-row">
        <strong>Paid On:</strong>
        <span><?= $payment['created_at'] ?></span>
    </div>

    <div class="thank-you">
        ✅ Thank you for your order! We'll begin preparing your food right away.
    </div>
</div>

</body>
</html>
