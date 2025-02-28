<?php
include 'config.php';

$error = $success = "";

// Check if a schedule ID is provided in the URL for deletion
if (isset($_GET['id'])) {
    $scheduleId = $_GET['id'];

    // SQL query to delete the schedule with the given ID
    $sql = "DELETE FROM schedule WHERE scheduleId = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Check if the preparation is successful
    if ($stmt === false) {
        $error = "Error preparing statement: " . $conn->error;
    } else {
        // Bind parameters to the prepared statement
        $stmt->bind_param("s", $scheduleId);

        // Execute the query
        if ($stmt->execute()) {
            $success = "Schedule deleted successfully!";
            header("Location: employeeschedule.php"); 
            exit();
        } else {
            $error = "Error deleting schedule: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
} else {
    $error = "No schedule ID provided!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <title>Delete Schedule</title>
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar">
        <h2>Supervisor Dashboard</h2>
        <ul class="sidebar-links">
            <li><a href="employeeschedule.php">Employee Schedule</a></li>
            <li><a href="supervisorleave.php">Leave Requests</a></li>
            <li><a href="timesheets.php">Timesheet Management</a></li>
            <li><a href="productreq.php">Timesheet Management</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="#logout" class="logout-btn">Logout</a>
    </div>

<div class="container">
    <div class="profile-header">
        <h1>Delete Schedule</h1>
    </div>

    <!-- Display Error/Success Messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Confirmation to Delete Schedule -->
    <?php if (isset($scheduleId)): ?>
        <p>Are you sure you want to delete the schedule with ID: <?php echo $scheduleId; ?>?</p>
        <a href="deleteSchedule.php?id=<?php echo $scheduleId; ?>" class="btn-confirm">Yes, Delete</a>
        <a href="employeeschedule.php" class="btn-cancel">Cancel</a>
    <?php endif; ?>
</div>

</body>
</html>
