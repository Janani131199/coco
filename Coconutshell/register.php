<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Coconut Shell</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>

<!-- Navigation Bar -->
<header class="nav-bar">
    <div class="logo">
        <img src="../images/logo.jpg" alt="Coconut Shell" />
        <span>Coconut Shell</span>
    </div>

    <nav class="nav-links">
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="tiffin.php">Tiffin</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
    </nav>
</header>

<!-- Registration Form -->
<section class="form-section">
    <h2>Create an Account</h2>
    <form class="user-form" method="POST" action="register_submit.php">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="cta-button">Register</button>
        <p class="form-text">Already have an account? <a href="login.php">Login here</a></p>
    </form>
</section>

</body>
</html>
