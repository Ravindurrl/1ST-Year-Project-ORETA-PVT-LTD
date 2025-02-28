<?php
include 'config.php';

// Get the current month and year, or use the month/year from the query string if set
$currentYear = isset($_GET['year']) ? $_GET['year'] : date("Y");
$currentMonth = isset($_GET['month']) ? $_GET['month'] : date("m");

// Fetch events from the database
$sql = "SELECT * FROM events";
$result = $conn->query($sql);

if ($result === false) {
    die("Error in SQL query: " . $conn->error);
}

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Calculate the number of days in the current month
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

// Calculate the first day of the month
$firstDayOfMonth = date("w", strtotime("$currentYear-$currentMonth-01"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Calendar</title>
    <link rel="stylesheet" href="Supevisoradd.css">
    <style>
       .calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
    text-align: center;
    background-color: white;
    padding: 7px;
    border-radius: 8px;
    font-size: 12px;
    max-width: 140%;
    margin: 0 auto;
}

.weekday-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
    font-weight: bold;
    margin-bottom: 5px;
    background-color: white;
    padding: 5px;
    border-radius: 8px;
    font-size: 12px;
}

.day {
    border: 1px solid #ccc;
    padding: 5px;
    min-height: 60px;
    font-size: 12px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
}

.day.event {
    background-color: #f0f8ff;
}

.event-title {
    font-size: 10px;
    color: #333;
    margin-top: 5px;
}

.delete-btn, .update-btn {
    background-color: red;
    color: white;
    padding: 4px 8px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 10px;
}

.delete-btn:hover, .update-btn:hover {
    background-color: darkred;
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

    <div class="container">
        <h1>Event Calendar</h1><br><br>

        <!-- Weekday headers (Sun, Mon, Tue, etc.) -->
        <div class="weekday-header">
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
        </div>

        <div class="calendar">
    <?php
    // Empty slots before the first day of the month
    for ($i = 0; $i < $firstDayOfMonth; $i++) {
        echo "<div class='day'></div>";
    }

    // Loop through all the days in the current month
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = sprintf('%s-%02d-%02d', $currentYear, $currentMonth, $day);
        $eventDetails = "";

        // Check if there are events for this day
        foreach ($events as $event) {
            if ($event['Event_date'] === $date) {
                $eventDetails .= "<div class='event-title'>{$event['Event_name']} ({$event['Event_type']})</div>";
                // Add event location
                $eventDetails .= "<div class='event-location'>Location: {$event['Location']}</div>";
                $eventDetails .= "<form method='GET' action='eventupdate.php'>";
                $eventDetails .= "<input type='hidden' name='Event_id' value='{$event['Event_id']}'>";
                $eventDetails .= "<button type='submit' style='background-color: green; color: white; border: none; padding: 5px 5px; border-radius: 5px; cursor: pointer;'>Update Event</button>";
                $eventDetails .= "</form>";
                
                // Add delete button
                $eventDetails .= "<form method='POST' action='eventdelete.php' onsubmit='return confirm(\"Are you sure you want to delete this event?\");'>";
                $eventDetails .= "<input type='hidden' name='event_id' value='{$event['Event_id']}'>";
                $eventDetails .= "<button type='submit' class='delete-btn'>Delete Event</button>";
                $eventDetails .= "</form>";
            }
        }

        $class = $eventDetails ? "day event" : "day";
        echo "<div class='$class'>";
        echo "<strong>$day</strong>";
        echo $eventDetails;
        echo "</div>";
    }
    ?>
</div>

        <button onclick="window.location.href='eventadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer;">
            Add New Event
        </button>

        <div class="calendar-header">
            <!-- Previous Month Button -->
            <button onclick="location.href='?month=<?= ($currentMonth - 1) < 1 ? 12 : $currentMonth - 1 ?>&year=<?= ($currentMonth - 1) < 1 ? $currentYear - 1 : $currentYear ?>'">Previous Month</button>
            <!-- Current Month and Year -->
            <span><?= date("F Y", strtotime("$currentYear-$currentMonth-01")) ?></span>
            <!-- Next Month Button -->
            <button onclick="location.href='?month=<?= ($currentMonth + 1) > 12 ? 1 : $currentMonth + 1 ?>&year=<?= ($currentMonth + 1) > 12 ? $currentYear + 1 : $currentYear ?>'">Next Month</button>
        </div>
    </div>
    

</body>
</html>
