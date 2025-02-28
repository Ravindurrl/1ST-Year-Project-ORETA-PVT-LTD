<?php
include 'config.php';

// Check if an event ID is passed in the URL
if (!isset($_GET['Event_id'])) {
    die("Event ID not provided.");
}

$event_id = $_GET['Event_id'];

// Fetch the current event details from the database
$sql = "SELECT * FROM events WHERE Event_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if event exists
if ($result->num_rows === 0) {
    die("Event not found.");
}

$event = $result->fetch_assoc();

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated event details from the form
    $event_name = $_POST['Event_name'];
    $event_date = $_POST['Event_date'];
    $event_type = $_POST['Event_type'];
    $event_location = $_POST['Location'];

    // Update the event in the database
    $update_sql = "UPDATE events SET event_name = ?, event_date = ?, event_type = ?, location = ? WHERE Event_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssi", $event_name, $event_date, $event_type, $event_location, $event_id);
    $update_stmt->execute();

    // Redirect to the event view page
    header("Location: eventview.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Event</title>
    <link rel="stylesheet" href="Supevisoradd.css">
    <style>
    .form-container {
        width: 60%;
        margin: 50px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    label {
        display: block;
        font-size: 16px;
        margin-bottom: 8px;
        color: #333;
    }

    input[type="text"],
    input[type="date"],
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    select {
        cursor: pointer;
    }

    button[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    select:focus {
        border-color: #4CAF50;
        outline: none;
    }

    input:invalid {
        border-color: red;
    }

    input:invalid:focus {
        border-color: red;
    }
    </style>
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

<div class="form-container">
    <h2>Update Event</h2>

    <form method="POST" action="eventupdate.php?Event_id=<?php echo $event_id; ?>">
    <label for="Event_name">Event Name:</label>
    <input type="text" name="Event_name" id="Event_name" value="<?php echo htmlspecialchars($event['event_name'] ?? ''); ?>">

    <label for="Event_date">Event Date:</label>
    <input type="date" name="Event_date" id="Event_date" value="<?php echo $event['event_date'] ?? ''; ?>" >

    <label for="Event_type">Event Type:</label>
    <input type="text" name="Event_type" id="Event_type" value="<?php echo htmlspecialchars($event['event_type'] ?? ''); ?>" >

    <label for="Location">Event Location:</label>
    <input type="text" name="Location" id="Location" value="<?php echo htmlspecialchars($event['location'] ?? ''); ?>" >

    <button type="submit">Update Event</button>
</form>
</div>

</body>
</html>
