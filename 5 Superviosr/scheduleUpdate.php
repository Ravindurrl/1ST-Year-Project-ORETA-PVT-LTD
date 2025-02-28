<?php
include 'config.php';

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateSchedule'])) {
        // Get the input values
        $scheduleId = $_POST['scheduleId'];
        $taskType = $_POST['taskType'];
        $description = $_POST['scheduleDescription'];
        $startDate = $_POST['scheduleStartDate'];
        $endDate = $_POST['scheduleEndDate'];

        // SQL query to update the schedule data
        $sql = "UPDATE schedule 
                SET taskType = ?, scheduleDescription = ?, scheduleStartDate = ?, scheduleEndDate = ? 
                WHERE scheduleId = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sssss", $taskType, $description, $startDate, $endDate, $scheduleId);

            // Execute the query
            if ($stmt->execute()) {
                header("Location: employeeschedule.php");
                exit();
            } else {
                $error = "Error updating schedule: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch the schedule details for the given ID
if (isset($_GET['id'])) {
    $scheduleId = $_GET['id'];
    $sql = "SELECT * FROM schedule WHERE scheduleId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $scheduleId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $schedule = $result->fetch_assoc();
    } else {
        $error = "Schedule not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <title>Update Schedule</title>
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar">
        <h2>Supervisor Dashboard</h2>
        <ul class="sidebar-links">
            <li><a href="employeeschedule.php">Employee Schedule</a></li>
            <li><a href="supervisorleave.php">Leave Requests</a></li>
            <li><a href="timesheets.php">Timesheet Management</a></li>
            <li><a href="productreq.php">Product Request</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="splogout.php" class="logout-btn">Logout</a>
    </div>

<div class="container">
    <div class="profile-header">
        <h1>Update Schedule</h1>
    </div>

    <!-- Display Error/Success Messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Schedule Update Form -->
    <?php if (isset($schedule)): ?>
        <form method="POST">
            <label for="scheduleId">Schedule ID:</label>
            <input type="text" name="scheduleId" value="<?php echo $schedule['scheduleId']; ?>" readonly>
            
            <label for="taskType">Task Type:</label>
            <input type="text" name="taskType" value="<?php echo $schedule['taskType']; ?>" required>
            
            <label for="scheduleDescription">Description:</label>
            <input type="text" name="scheduleDescription" value="<?php echo $schedule['scheduleDescription']; ?>" required>
            
            <label for="scheduleStartDate">Start Date:</label>
            <input type="date" name="scheduleStartDate" value="<?php echo $schedule['scheduleStartDate']; ?>" required>
            
            <label for="scheduleEndDate">End Date:</label>
            <input type="date" name="scheduleEndDate" value="<?php echo $schedule['scheduleEndDate']; ?>" required>
            
            <button type="submit" name="updateSchedule">Update Schedule</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
