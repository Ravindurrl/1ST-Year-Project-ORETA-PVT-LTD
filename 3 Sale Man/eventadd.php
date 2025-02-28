<?php
include 'config.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = $_POST['event_id'];  // Accept event_id from the form
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_type = $_POST['event_type'];
    $location = $_POST['location'];

    // Insert the event into the database with manual event_id
    $sql = "INSERT INTO events (Event_id, Event_name, Event_date, Event_type, Location) 
            VALUES ('$event_id', '$event_name', '$event_date', '$event_type', '$location')";

    if ($conn->query($sql) === TRUE) {
        header("Location: eventview.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>
     <!-- Sidebar Navigation -->
     <div class="sidebar">
        <h2>Sales & Marketing Manager</h2>
        <ul class="sidebar-links">
            <li><a href="viewsalesperson.php">View Sales Person</a></li>
            <li><a href="vieworders.php">View Orders</a></li>
            <li><a href="deliverypartner.php">View Delivery Partners</a></li>
            <li><a href="generateDiscount.php">Generate Discount</a></li>
            <li><a href="viewsalestarget.php">View Sales Target</a></li>
            <li><a href="viewproducts.php">View Products</a></li>
            <li><a href="generatebusinessplan.php">Generate Business Plan</a></li>
            <li><a href="viewinventory.php">View Inventory</a></li>
            <li><a href="eventview.php">View Event</a></li>

        </ul>
        <!-- Logout Button -->
        <a href="slmlogout.php" class="logout-btn">Logout</a>
    </div>
    <!-- Add Event Form -->
    <form method="POST" action="eventadd.php">
        <h1>Add New Event</h1>

        <label for="event_id">Event ID:</label>
        <input type="text" id="event_id" name="event_id" required><br><br>

        <label for="event_name">Event Name:</label>
        <input type="text" id="event_name" name="event_name" required><br><br>

        <label for="event_date">Event Date:</label>
        <input type="date" id="event_date" name="event_date" required><br><br>

        <label for="event_type">Event Type:</label>
        <input type="text" id="event_type" name="event_type" required><br><br>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required><br><br>

        <button type="submit">Add Event</button>
    </form>
</body>
</html>
