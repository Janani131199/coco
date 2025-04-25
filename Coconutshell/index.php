<?php session_start(); ?>
<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Coconut Shell Thunder Bay</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>


<header class="nav-bar">
    <div class="logo">
        <img src="images/logo.jpg" alt="Coconut Shell" />
        <span>Coconut Shell</span>
    </div>

    <nav class="nav-links">
        <a href="#">Home</a>
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

    <div class="contact-action">
        <a href="reservation.php" class="cta-button">Book a Table</a>
    </div>
</header>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h4>Welcome To</h4>
        <h1>Coconut Shell</h1>
        <p>HOME OF THE BEST SOUTH INDIAN FOOD</p>
        <a href="menu.php" class="cta-button">View Menu</a>
    </div>
</section>

<?php session_start(); ?>
<!-- in your header -->
<?php if (isset($_SESSION['name'])): ?>
    <p style="color:white;">Welcome, <?php echo $_SESSION['name']; ?>!</p>
<?php endif; ?>

</body>
</html>
