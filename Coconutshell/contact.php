<?php //include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Coconut Shell</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>

<!-- Header -->
<header class="nav-bar">
    <div class="logo">
        <img src="../images/logo.jpg" alt="Coconut Shell" />
        <span>Coconut Shell</span>
    </div>

    <nav class="nav-links">
        <a href="../index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="tiffin.php">Tiffin</a>
        <a href="about.php">About</a>
        <a href="contact.php" class="active">Contact</a>
    </nav>
</header>

<!-- Contact Form Section -->
<section class="contact-section">
    <h2>Contact Us</h2>
    <form class="contact-form" method="POST" action="contact_submit.php">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="text" name="address" placeholder="Your Address" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
        <button type="submit" class="cta-button">Send Message</button>
    </form>
</section>

</body>
</html>
