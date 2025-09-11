<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>RaidOn - Student Ride Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>🚍 RaidOn – Student Ride Booking</h1>
    <?php if(isset($_SESSION['user_id'])): ?>
        <p>Welcome, <?php echo $_SESSION['user_name']; ?> | <a href="logout.php">Logout</a></p>
        <a href="booking.php">Book a Ride</a>
    <?php else: ?>
        <a href="register.php">Register</a> | 
        <a href="login.php">Login</a>
    <?php endif; ?>
</body>
</html>
