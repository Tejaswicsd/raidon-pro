<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bus_id = $_POST['bus_id'];
    $stop_id = $_POST['stop_id'];
    
    // find next available seat
    $seat_query = "SELECT COUNT(*) as booked FROM bookings WHERE bus_id=?";
    $stmt = $conn->prepare($seat_query);
    $stmt->bind_param("i", $bus_id);
    $stmt->execute();
    $seat_res = $stmt->get_result()->fetch_assoc();
    $booked = $seat_res['booked'];

    $bus_query = "SELECT total_seats FROM buses WHERE id=?";
    $stmt = $conn->prepare($bus_query);
    $stmt->bind_param("i", $bus_id);
    $stmt->execute();
    $bus_res = $stmt->get_result()->fetch_assoc();
    $total_seats = $bus_res['total_seats'];

    if ($booked < $total_seats) {
        $seat_number = $booked + 1;
        $sql = "INSERT INTO bookings (user_id, bus_id, stop_id, seat_number) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $_SESSION['user_id'], $bus_id, $stop_id, $seat_number);
        if ($stmt->execute()) {
            header("Location: confirm.php?seat=$seat_number");
        }
    } else {
        echo "Sorry, no seats available!";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Book Ride</title></head>
<body>
<h2>Book Your Ride</h2>
<form method="post">
    <label>Select Bus:</label>
    <select name="bus_id">
        <?php
        $buses = $conn->query("SELECT * FROM buses");
        while ($bus = $buses->fetch_assoc()) {
            echo "<option value='{$bus['id']}'>{$bus['bus_name']} - {$bus['route']}</option>";
        }
        ?>
    </select><br><br>
    <label>Select Stop:</label>
    <select name="stop_id">
        <?php
        $stops = $conn->query("SELECT * FROM stops");
        while ($stop = $stops->fetch_assoc()) {
            echo "<option value='{$stop['id']}'>{$stop['stop_name']}</option>";
        }
        ?>
    </select><br><br>
    <button type="submit">Book</button>
</form>
</body>
</html>
