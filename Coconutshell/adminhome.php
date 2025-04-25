<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Coconut Shell</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Header -->
<header class="nav-bar">
    <div class="logo">
        <img src="images/logo.jpg" alt="Logo" height="50">
        <span>Coconut Shell</span>
    </div>
    <nav class="nav-links">
        <a href="adminhome.php">Home</a>
        <a href="edit_menu.php"> Menu Items</a>
        <a href="edit_tiffin.php">Tiffin Services</a>
        <a href="view_orders.php">View Orders</a>

        <a href="logout.php" style="color: red;">Logout</a>
    </nav>
    <a href="reservation.php" class="book-btn">Book a Table</a>
</header>

<!-- Admin Welcome -->
<section class="form-section">
    <h2>Welcome, Admin <?= $_SESSION['name']; ?> 👋</h2>
    <p>Use the links above to manage menus, users, and services.</p>
</section>

</body>
</html>
