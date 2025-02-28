<?php
include 'config.php'; 
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateAttendance'])) {
        // Get the input values from the form
        $atid = $_POST['atid'];
        $atestatus = $_POST['atestatus'];
        $atedate = $_POST['atedate'];
        $workhours = $_POST['workhours'];
        $emp_id = $_POST['emp_id'];

        // SQL query to update the attendance data
        $sql = "UPDATE attendance 
                SET atestatus = ?, atedate = ?, workhours = ?, emp_id = ? 
                WHERE atid = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("ssdii", $atestatus, $atedate, $workhours, $emp_id, $atid);

            // Execute the query
            if ($stmt->execute()) {
                // Success
                $success = "Attendance record updated successfully!";
                header("Location: attendence.php"); 
                exit();
            } else {
                
                $error = "Error updating attendance record: " . $stmt->error;
            }

         
            $stmt->close();
        }
    }
}

if (isset($_GET['id'])) {
    $atid = $_GET['id'];

    // Query to fetch the current record
    $sql = "SELECT * FROM attendance WHERE atid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $atid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Store fetched values to pre-fill the form
        $atestatus = $row['atestatus'];
        $atedate = $row['atedate'];
        $workhours = $row['workhours'];
        $emp_id = $row['emp_id'];
    } else {
        $error = "Attendance record not found!";
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
    <title>Update Attendance Record</title>
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

<!-- Attendance Update Form -->
<div class="main-content">
    <h1>Update Attendance Record</h1>
    <form method="POST">
        
        <input type="hidden" name="atid" value="<?php echo $atid; ?>">

        <label for="atestatus">Attendance Status</label>
        <input type="text" name="atestatus" value="<?php echo $atestatus; ?>" placeholder="Enter attendance status" required><br>

        <label for="atedate">Attendance Date</label>
        <input type="date" name="atedate" value="<?php echo $atedate; ?>" required><br>

        <label for="workhours">Work Hours</label>
        <input type="number" step="0.1" name="workhours" value="<?php echo $workhours; ?>" placeholder="Enter work hours" required><br>

        <label for="emp_id">Employee ID</label>
        <input type="number" name="emp_id" value="<?php echo $emp_id; ?>" placeholder="Enter employee ID" required><br>

        <button type="submit" name="updateAttendance">Update Attendance Record</button>
    </form>
</div>

</body>
</html>
