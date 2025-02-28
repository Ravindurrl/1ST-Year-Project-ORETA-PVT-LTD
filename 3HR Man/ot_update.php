<?php
include 'config.php'; 
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateOT'])) {
        
        $otid = $_POST['otid'];
        $emp_id = $_POST['emp_id'];
        $employeeName = $_POST['employeeName'];
        $otDate = $_POST['otDate'];
        $overtimeHours = $_POST['overtimeHours'];
        $otAmount = $_POST['otAmount'];  
        $otRate = 500;

        // Calculate OT Amount
        $otAmount = $overtimeHours * $otRate;

        // SQL query to update the overtime data
        $sql = "UPDATE ot 
                SET emp_id = ?, EmployeeName = ?, OTDate = ?, OvertimeHours = ?, OTAmount = ? 
                WHERE OTID = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("issdii", $emp_id, $employeeName, $otDate, $overtimeHours, $otAmount, $otid);

            // Execute the query
            if ($stmt->execute()) {
                // Success
                $success = "Overtime record updated successfully!";
                header("Location: ot.php"); 
                exit();
            } else {
                $error = "Error updating overtime record: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

if (isset($_GET['id'])) {
    $otid = $_GET['id'];

    
    $sql = "SELECT * FROM ot WHERE OTID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $otid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Store fetched values to pre-fill the form
        $emp_id = $row['emp_id'];
        $employeeName = $row['EmployeeName'];
        $otDate = $row['OTDate'];
        $overtimeHours = $row['OvertimeHours'];
        $otAmount = $row['OTAmount'];
    } else {
        $error = "Overtime record not found!";
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Overtime Record</title>
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
        <a href="hrlogout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Success/Error Messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>
    <style>
/* Form styling */
form {
    display: grid;
    gap: 10px;
}
</style>
    <!-- Overtime Update Form -->
    <div class="main-content">
        <h1>Update Overtime Record</h1>
        <form method="POST">
            <input type="hidden" name="otid" value="<?php echo $otid; ?>">

            <label for="emp_id">Employee ID</label>
            <input type="number" name="emp_id" value="<?php echo $emp_id; ?>" placeholder="Enter employee ID" required><br>

            <label for="employeeName">Employee Name</label>
            <input type="text" name="employeeName" value="<?php echo $employeeName; ?>" placeholder="Enter employee name" required><br>

            <label for="otDate">Overtime Date</label>
            <input type="date" name="otDate" value="<?php echo $otDate; ?>" required><br>

            <label for="overtimeHours">Overtime Hours</label>
            <input type="number" step="0.1" name="overtimeHours" value="<?php echo $overtimeHours; ?>" placeholder="Enter overtime hours" required><br>

            <label for="otAmount">Overtime Amount</label>
            <input type="number" name="otAmount" value="<?php echo $otAmount; ?>" readonly><br>

            <button type="submit" name="updateOT">Update Overtime Record</button>
        </form>
    </div>

</body>
</html>
