<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome - Coconut Shell</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="nav-bar">
    <div class="logo">
        <img src="images/logo.jpg" height="40">
        <span>Coconut Shell</span>
    </div>
    <nav class="nav-links">
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="tiffin.php">Tiffin</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>

        <?php if (isset($_SESSION['role'])): ?>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="adminhome.php">Admin</a>
            <?php endif; ?>
            <a href="logout.php" style="color: red;">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>

<section class="form-section">
    <h2>Welcome <?= isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest'; ?>!</h2>
    <p>This is the Coconut Shell homepage for users.</p>
</section>

</body>
</html>
