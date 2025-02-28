<?php
include 'config.php'; 
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addAttendance'])) {
        // Get the input values from the form
        $atestatus = $_POST['atestatus'];
        $atedate = $_POST['atedate'];
        $workhours = $_POST['workhours'];
        $emp_id = $_POST['emp_id'];

        // SQL query to insert the attendance data
        $sql = "INSERT INTO attendance (atestatus, atedate, workhours, emp_id) 
                VALUES (?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("ssdi", $atestatus, $atedate, $workhours, $emp_id);

            // Execute the query
            if ($stmt->execute()) {
                // Success
                $success = "Attendance record added successfully!";
                header("Location: attendence.php"); 
                exit();
            } else {
                // Error
                $error = "Error adding attendance record: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Attendance Record</title>
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

<!-- Attendance Add Form -->
<div class="main-content">
    <h1>Add New Attendance Record</h1>
    <form method="POST">
        <label for="atestatus">Attendance Status</label>
        <input type="text" name="atestatus" placeholder="Enter attendance status (e.g., Present, Absent)" required><br>

        <label for="atedate">Attendance Date</label>
        <input type="date" name="atedate" required><br>

        <label for="workhours">Work Hours</label>
        <input type="number" step="0.1" name="workhours" placeholder="Enter work hours" required><br>

        <label for="emp_id">Employee ID</label>
        <input type="number" name="emp_id" placeholder="Enter employee ID" required><br>

        <button type="submit" name="addAttendance">Save Attendance Record</button>
    </form>
</div>

</body>
</html>
