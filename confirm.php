<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head><title>Booking Confirmation</title></head>
<body>
<h2>Booking Confirmed ✅</h2>
<p>Your seat number: <?php echo $_GET['seat']; ?></p>
<a href="index.php">Go Home</a>
</body>
</html>
