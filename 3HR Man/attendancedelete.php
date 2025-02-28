<?php
include 'config.php'; 
$error = $success = "";

if (isset($_GET['id'])) {
    $atid = $_GET['id'];

    
    $sql = "DELETE FROM attendance WHERE atid = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Check if the preparation is successful
    if ($stmt === false) {
        $error = "Error preparing statement: " . $conn->error;
    } else {
        // Bind parameters to the prepared statement
        $stmt->bind_param("i", $atid);

        // Execute the query
        if ($stmt->execute()) {
            // Success
            $success = "Attendance record deleted successfully!";
            header("Location: attendence.php"); 
            exit();
        } else {
            // Error
            $error = "Error deleting attendance record: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
} else {
    $error = "No attendance ID provided!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Attendance Record</title>
    <link rel="stylesheet" href="Supevisoradd.css"> <!-- Adjust as needed -->
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar">
        <h2>HR Manager</h2>
        <ul class="sidebar-links">
            <li><a href="payrollreport.php">Payroll Reports</a></li>
            <li><a href="attendence.php">Monitor Attendance</a></li>
            <li><a href="leavereport.php">Employee Leave Report</a></li>
            <li><a href="ot.php">View Overtime (OT)</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="#logout" class="logout-btn">Logout</a>
    </div>

<!-- Success/Error Messages -->
<?php if (!empty($error)): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <p class="success"><?php echo $success; ?></p>
<?php endif; ?>

<!-- Confirm Deletion Message -->
<div class="main-content">
    <h1>Delete Attendance Record</h1>
    <p>Are you sure you want to delete this attendance record?</p>
    <a href="deleteattendance.php?id=<?php echo $atid; ?>" class="confirm-btn" onclick="return confirm('Are you sure you want to delete this attendance record?')">Yes, Delete</a>
    <a href="attendence.php" class="cancel-btn">Cancel</a>
</div>

</body>
</html>
