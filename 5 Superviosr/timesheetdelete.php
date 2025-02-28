<?php
include 'config.php';

$error = $success = "";

if (isset($_GET['id'])) {
    $timesheetId = $_GET['id'];

    // SQL query to delete the timesheet
    $sql = "DELETE FROM timesheet WHERE timesheetId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $timesheetId);

    if ($stmt->execute()) {
        $success = "Timesheet deleted successfully!";
    } else {
        $error = "Error deleting timesheet: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <title>Delete Timesheet</title>
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
        <a href="splogout.php" class="logout-btn">Logout</a>
    </div>

<div class="container">
    <div class="profile-header">
        <h1>Delete Timesheet</h1>
    </div>

    <!-- Display success or error messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

</div>

</body>
</html>
