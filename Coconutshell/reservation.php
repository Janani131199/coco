<?php session_start(); ?>

<?php // include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Table - Coconut Shell Thunder Bay</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>

<!-- Navigation -->
<header class="nav-bar">
    <div class="logo">
       <img src="images/logo.jpg" alt="Coconut Shell" />
        <span>Coconut Shell</span>
    </div>

    <nav class="nav-links">
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="tiffin.php">Tiffin</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <?php if (isset($_SESSION['email'])): ?>
    <span style="color: #fff; margin-right: 10px;">Hi, <?= $_SESSION['name']; ?></span>
    <a href="logout.php" style="color: red;">Logout</a>
<?php else: ?>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
<?php endif; ?>
    </nav>

    
</header>

<!-- Reservation Form -->
<section class="reservation-section">
    <div class="form-container">
        <h2>Book a Table</h2>
        <form method="post" action="#">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <input type="date" name="date" required>
            <input type="time" name="time" required>
            <input type="number" name="guests" placeholder="Number of Guests" min="1" required>
            <button type="submit" class="cta-button">Submit Reservation</button>
        </form>
    </div>
</section>

</body>
</html>
