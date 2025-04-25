<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Add new tiffin
if (isset($_POST['add'])) {
    $day     = mysqli_real_escape_string($conn, $_POST['day']);
    $type    = $_POST['type'];
    $items   = mysqli_real_escape_string($conn, $_POST['items']);

    if ($_FILES['image']['error'] === 0) {
        $imgData = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $imgType = $_FILES['image']['type'];
        $sql = "INSERT INTO tiffin_service (day, type, items, image, image_type)
                VALUES ('$day', '$type', '$items', '$imgData', '$imgType')";
        mysqli_query($conn, $sql);
    }
}

// Update existing
if (isset($_POST['update'])) {
    $id    = $_POST['id'];
    $day   = mysqli_real_escape_string($conn, $_POST['day']);
    $type  = $_POST['type'];
    $items = mysqli_real_escape_string($conn, $_POST['items']);

    if ($_FILES['image']['error'] === 0) {
        $imgData = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $imgType = $_FILES['image']['type'];
        $query = "UPDATE tiffin_service SET day='$day', type='$type', items='$items', image='$imgData', image_type='$imgType' WHERE id=$id";
    } else {
        $query = "UPDATE tiffin_service SET day='$day', type='$type', items='$items' WHERE id=$id";
    }

    mysqli_query($conn, $query);
    echo "<script>alert('Tiffin updated!'); window.location='edit_tiffin.php';</script>";
}

// Delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    mysqli_query($conn, "DELETE FROM tiffin_service WHERE id=$id");
    echo "<script>alert('Tiffin deleted!'); window.location='edit_tiffin.php';</script>";
}

$tiffins = mysqli_query($conn, "SELECT * FROM tiffin_service ORDER BY FIELD(type, 'breakfast', 'dinner'), day");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Tiffin Service</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
        input, select, textarea, button {
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
        textarea {
            resize: vertical;
            min-height: 50px;
        }
    </style>
</head>
<body>

<h2>Edit Tiffin Service</h2>

<h3>Add New Tiffin</h3>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="day" placeholder="Day (e.g., Monday)" required>
    <select name="type" required>
        <option value="breakfast">Breakfast</option>
        <option value="dinner">Dinner</option>
    </select>
    <textarea name="items" placeholder="Tiffin Items (comma separated)" required></textarea>
    <input type="file" name="image" accept="image/*" required>
    <button type="submit" name="add">Add Tiffin</button>
</form>

<h3>Current Tiffins</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Day</th>
        <th>Type</th>
        <th>Items</th>
        <th>Image</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($tiffins)): ?>
    <tr>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <td><?= $row['id'] ?></td>
            <td><input type="text" name="day" value="<?= htmlspecialchars($row['day']) ?>"></td>
            <td>
                <select name="type">
                    <option value="breakfast" <?= $row['type'] == 'breakfast' ? 'selected' : '' ?>>Breakfast</option>
                    <option value="dinner" <?= $row['type'] == 'dinner' ? 'selected' : '' ?>>Dinner</option>
                </select>
            </td>
            <td><textarea name="items"><?= htmlspecialchars($row['items']) ?></textarea></td>
            <td>
                <?php if (!empty($row['image'])): ?>
                    <img src="data:<?= $row['image_type'] ?>;base64,<?= base64_encode($row['image']) ?>" alt="Image">
                <?php else: ?>
                    No Image
                <?php endif; ?>
                <br>
                <input type="file" name="image">
            </td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <button type="submit" name="update">Update</button>
                <button type="submit" name="delete" onclick="return confirm('Delete this tiffin?')">Delete</button>
            </td>
        </form>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
