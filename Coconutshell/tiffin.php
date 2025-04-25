<?php
session_start();
include 'db.php';

// Fetch tiffin data from database
global $conn;
$breakfasts = mysqli_query($conn, "SELECT * FROM tiffin_service WHERE type = 'breakfast' ORDER BY id ASC");
$dinners    = mysqli_query($conn, "SELECT * FROM tiffin_service WHERE type = 'dinner' ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tiffin Service - Coconut Shell</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        .tiffin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .tiffin-card {
            background: #2b2b2b;
            border-radius: 12px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            color: white;
            overflow: hidden;
        }

        .tiffin-card img {
            max-height: 120px;
            border-radius: 8px;
            margin-top: 10px;
            object-fit: cover;
            width: 100%;
        }

        .day-heading {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #ffcc70;
        }

        .book-btn {
            margin-top: 10px;
            align-self: flex-start;
            background: #D38B5D;
            color: white;
            border: none;
            padding: 6px 12px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header class="nav-bar">
    <div class="logo">
        <img src="images/logo.jpg" alt="Coconut Shell" />
        <span>Coconut Shell</span>
    </div>

    <nav class="nav-links">
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="tiffin.php" class="active">Tiffin</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <?php if (isset($_SESSION['email'])): ?>
            <a href="logout.php" style="color: red;">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>

<!-- Tiffin Section -->
<section class="tiffin-section">
    <h2 style="text-align:center; color: #ffcc70;">Tiffin Service</h2>

    <div class="tiffin-tabs" style="text-align:center; margin-bottom: 20px;">
        <button onclick="showTiffin('breakfast')">Breakfast</button>
        <button onclick="showTiffin('dinner')">Dinner</button>
    </div>

    <!-- Breakfast Section -->
    <div class="tiffin-box breakfast">
        <div class="tiffin-grid">
            <?php while ($row = mysqli_fetch_assoc($breakfasts)): ?>
                <div class="tiffin-card">
                    <div class="day-heading">Day <?= htmlspecialchars($row['day']) ?></div>
                    <div class="item-desc"><?= htmlspecialchars($row['items']) ?></div>
                    <?php if (!empty($row['image'])): ?>
                        <img src="data:<?= $row['image_type'] ?>;base64,<?= base64_encode($row['image']) ?>" alt="Tiffin Image">
                    <?php endif; ?>
                    <a href="tel:8073586605" class="book-btn">📞 Book Now</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Dinner Section -->
    <div class="tiffin-box dinner" style="display: none;">
        <div class="tiffin-grid">
            <?php while ($row = mysqli_fetch_assoc($dinners)): ?>
                <div class="tiffin-card">
                    <div class="day-heading">Day <?= htmlspecialchars($row['day']) ?></div>
                    <div class="item-desc"><?= htmlspecialchars($row['items']) ?></div>
                    <?php if (!empty($row['image'])): ?>
                        <img src="data:<?= $row['image_type'] ?>;base64,<?= base64_encode($row['image']) ?>" alt="Tiffin Image">
                    <?php endif; ?>
                    <a href="tel:8073586605" class="book-btn">📞 Book Now</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<script>
function showTiffin(type) {
    document.querySelector('.breakfast').style.display = 'none';
    document.querySelector('.dinner').style.display = 'none';
    document.querySelector('.' + type).style.display = 'block';
}
</script>

</body>
</html>
