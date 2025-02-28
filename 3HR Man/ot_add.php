
<?php
include 'config.php'; // Include the database connection

$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the form
    $emp_id = $_POST['employee-id'];
    $employee_name = $_POST['employee-name'];
    $ot_date = $_POST['overtime-date'];
    $overtime_hours = $_POST['overtime-hours'];
    
    // Calculate OT amount 
    $rate_per_hour = 500; 
    $ot_amount = $overtime_hours * $rate_per_hour;

    // Insert OT record into database
    $sql = "INSERT INTO OT (emp_id, EmployeeName, OTDate, OvertimeHours, OTAmount) 
            VALUES ('$emp_id', '$employee_name', '$ot_date', '$overtime_hours', '$ot_amount')";

    if ($conn->query($sql) === TRUE) {
        $success = "Overtime record added successfully!";
        header("Location: ot.php"); 
    } else {
        $error = "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Overtime Record</title>

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

<div class="main-content">
    <h1>Add Overtime Record</h1>

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
    <!-- Overtime Form -->
    <form action="ot_add.php" method="POST">
        <label for="employee-id">Employee ID:</label>
        <input type="text" id="employee-id" name="employee-id" required>

        <label for="employee-name">Employee Name:</label>
        <input type="text" id="employee-name" name="employee-name" required>

        <label for="overtime-date">Overtime Date:</label>
        <input type="date" id="overtime-date" name="overtime-date" required>

        <label for="overtime-hours">Overtime Hours:</label>
<input type="number" id="overtime-hours" name="overtime-hours" required min="0.1" step="0.1">


        <button type="submit">Add Overtime Record</button>
    </form>
</div>

</body>
</html>
