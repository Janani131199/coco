<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location:index.php");
    exit();
}

include 'db.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders - Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .orders-section {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: #1a1a1a;
            border-radius: 12px;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {    
            padding: 12px;
            border-bottom: 1px solid #444;
            text-align: left;
        }
        th {
            background-color: #222;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

<header class="nav-bar">
    <div class="logo">
        <img src="images/logo.jpg" height="40">
        <span>Admin Panel - Coconut Shell</span>
    </div>
    <nav class="nav-links">
        <a href="adminhome.php">Home</a>
        <a href="edit_menu.php"> Menu</a>
        <a href="edit_tiffin.php">Tiffin Service</a>
        <a href="view_orders.php" class="active">View Orders</a>
        <?php if (isset($_SESSION['email'])): ?>
    <span style="color: #fff; margin-right: 10px;">Hi, <?= $_SESSION['name']; ?> </span>
    <a href="logout.php" style="color: red;">Logout</a>
<?php else: ?>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
<?php endif; ?>
    </nav>
</header>

<section class="orders-section">
    <h2>Customer Orders</h2>

    <table>
    <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Item</th>
        <th>Price</th>
        <th>Ordered At</th>
    </tr>

    <?php
    $query = "SELECT * FROM orders ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['customer_name']}</td>
                <td>{$row['item_name']}</td>
                <td>\${$row['item_price']}</td>
                <td>{$row['created_at']}</td>
              </tr>";
    }
    ?>
</table>


</section>
<button onclick="window.print()" class="cta-button" style="margin-bottom: 20px;">🖨️ Print Orders</button>

</body>
</html>
