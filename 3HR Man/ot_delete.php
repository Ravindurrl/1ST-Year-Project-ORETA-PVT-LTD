<?php
include 'config.php'; 

$error = $success = "";

if (isset($_GET['id'])) {
    $otid = $_GET['id'];

    $sql = "DELETE FROM ot WHERE OTID = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $error = "Error preparing statement: " . $conn->error;
    } else {
        
        $stmt->bind_param("i", $otid);

        // Execute the query
        if ($stmt->execute()) {
            $success = "Overtime record deleted successfully!";
            header("Location: ot.php");  
            exit();
        } else {
            $error = "Error deleting overtime record: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    $error = "Invalid OTID!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Overtime Record</title>
    <link rel="stylesheet" href="Supevisoradd.css">
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
</body>
</html>
