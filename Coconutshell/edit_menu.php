<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Add new item
if (isset($_POST['add'])) {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $price    = $_POST['price'];
    $category = $_POST['category'];

    if ($_FILES['image']['error'] === 0) {
        $imgData  = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $imgType  = $_FILES['image']['type'];

        $sql = "INSERT INTO menu (name, price, category, image, image_type) 
                VALUES ('$name', '$price', '$category', '$imgData', '$imgType')";
        mysqli_query($conn, $sql);
    }
}

// Update existing item
if (isset($_POST['update'])) {
    $id       = $_POST['id'];
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $price    = $_POST['price'];
    $category = $_POST['category'];

    if ($_FILES['image']['error'] === 0) {
        $imgData  = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $imgType  = $_FILES['image']['type'];
        $updateQuery = "UPDATE menu SET name='$name', price='$price', category='$category', image='$imgData', image_type='$imgType' WHERE id=$id";
    } else {
        $updateQuery = "UPDATE menu SET name='$name', price='$price', category='$category' WHERE id=$id";
    }

    mysqli_query($conn, $updateQuery);
    echo "<script>alert('Menu item updated!'); window.location='edit_menu.php';</script>";
}

// Delete item
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    mysqli_query($conn, "DELETE FROM menu WHERE id=$id");
    echo "<script>alert('Menu item deleted!'); window.location='edit_menu.php';</script>";
}

$items = mysqli_query($conn, "SELECT * FROM menu ORDER BY category, created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Edit Menu Items</title>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: #111;
            color: white;
            font-family: 'Open Sans', sans-serif;
            padding: 20px;
        }
        h2, h3 {
            text-align: center;
        }
        form, table {
            width: 90%;
            margin: 20px auto;
        }
        input, select, button {
            padding: 8px;
            margin: 5px;
            border-radius: 6px;
            border: none;
            font-size: 14px;
        }
        table {
            border-collapse: collapse;
            background: #1a1a1a;
        }
        th, td {
            padding: 10px;
            border: 1px solid #333;
            text-align: center;
        }
        img {
            max-height: 80px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
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
        
        <?php if (isset($_SESSION['email'])): ?>
    <span style="color: #fff; margin-right: 10px;"><?= $_SESSION['name']; ?></span>
    <a href="logout.php" style="color: red;">Logout</a>
<?php else: ?>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
<?php endif; ?>
    </nav>
    
</header>

<h2>Edit Menu Items</h2>

<h3>Add New Menu Item</h3>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Item Name" required>
    <input type="number" name="price" step="0.01" placeholder="Price" required>
    <select name="category" required>
        <option value="starter">Starter</option>
        <option value="main">Main</option>
        <option value="special">Special</option>
    </select>
    <input type="file" name="image" accept="image/*" required>
    <button type="submit" name="add">Add Item</button>
</form>

<h3>Current Menu Items</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price ($)</th>
        <th>Category</th>
        <th>Image</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($items)): ?>
    <tr>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <td><?= $row['id'] ?></td>
            <td><input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>"></td>
            <td><input type="number" step="0.01" name="price" value="<?= $row['price'] ?>"></td>
            <td>
                <select name="category">
                    <option value="starter" <?= $row['category'] == 'starter' ? 'selected' : '' ?>>Starter</option>
                    <option value="main" <?= $row['category'] == 'main' ? 'selected' : '' ?>>Main</option>
                    <option value="special" <?= $row['category'] == 'special' ? 'selected' : '' ?>>Special</option>
                </select>
            </td>
            <td>
                <?php if (!empty($row['image'])): ?>
                    <img src="data:<?= $row['image_type'] ?>;base64,<?= base64_encode($row['image']) ?>" alt="Item Image">
                <?php else: ?>
                    No Image
                <?php endif; ?>
                <br>
                <input type="file" name="image" accept="image/*">
            </td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <button type="submit" name="update">Update</button>
                <button type="submit" name="delete" onclick="return confirm('Delete this item?')">Delete</button>
            </td>
        </form>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
