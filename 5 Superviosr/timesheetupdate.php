<?php
include 'config.php';

$error = $success = "";

if (isset($_GET['id'])) {
    $timesheetId = $_GET['id'];

    // Fetch existing timesheet data
    $sql = "SELECT * FROM timesheet WHERE timesheetId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $timesheetId);
    $stmt->execute();
    $result = $stmt->get_result();
    $timesheet = $result->fetch_assoc();

    if (!$timesheet) {
        $error = "Timesheet not found.";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $timesheetDate = $_POST['timesheetDate']; 
        $timesheetDetails = $_POST['timesheetDetails']; 
        $emp_id = $_POST['emp_id']; 

        // Validate input fields
        if (empty($timesheetDate) || empty($timesheetDetails) || empty($emp_id)) {
            $error = "Please fill out all required fields.";
        } else {
            // SQL query to update the timesheet data
            $sql = "UPDATE timesheet SET timesheetDate = ?, timesheetDetails = ?, emp_id = ? WHERE timesheetId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssii", $timesheetDate, $timesheetDetails, $emp_id, $timesheetId);

            if ($stmt->execute()) {
                $success = "Timesheet updated successfully!";
                header("Location: timesheets.php");
            } else {
                $error = "Error updating timesheet: " . $stmt->error;
            }
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
    <link rel="stylesheet" href="Supevisoradd.css">
    <title>Update Timesheet</title>
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
        <h1>Update Timesheet</h1>
    </div>

    <!-- Display success or error messages -->
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
        column-width: 20px;
    }</style>
            <!-
    <!-- Form to update the timesheet -->
    <form method="POST">
        <label for="timesheetDate">Timesheet Date:</label>
        <input type="date" name="timesheetDate" value="<?php echo $timesheet['timesheetDate']; ?>" required>

        <label for="timesheetDetails">Details:</label>
        <input type="text" name="timesheetDetails" value="<?php echo $timesheet['timesheetDetails']; ?>" required>

        <label for="emp_id">Employee ID:</label>
        <input type="number" name="emp_id" value="<?php echo $timesheet['emp_id']; ?>" required>

        <button type="submit">Update Timesheet</button>
    </form>
</div>

</body>
</html>
