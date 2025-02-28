<?php
include 'config.php'; 

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addTimesheet'])) {
        // Get the input values
        $timesheetId = $_POST['timesheetId'];
        $timesheetDate = $_POST['timesheetDate'];
        $timesheetDetails = $_POST['timesheetDetails'];
        $emp_id = $_POST['emp_id'];  

        // Validate input fields
        if (empty($timesheetId) || empty($timesheetDate) || empty($timesheetDetails) || empty($emp_id)) {
            $error = "Please fill out all required fields.";
        } else {
            // SQL query to insert the timesheet data
            $sql = "INSERT INTO timesheet (timesheetId, timesheetDate, timesheetDetails, emp_id) 
                    VALUES (?, ?, ?, ?)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                $error = "Error preparing statement: " . $conn->error;
            } else {
                
                $stmt->bind_param("sssi", $timesheetId, $timesheetDate, $timesheetDetails, $emp_id); // Bind values for the query

                // Execute the query
                if ($stmt->execute()) {
                    // Redirect after successful addition
                    $success = "Timesheet added successfully!";
                    header("Location: timesheets.php");
                    exit();
                } else {
                    $error = "Error adding timesheet: " . $stmt->error;
                }

                $stmt->close();
            }
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
    <title>Add Timesheet</title>
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
        <h1>Add Timesheet</h1>
    </div>


    <form method="POST">
        <label for="timesheetId">Timesheet ID:</label>
        <input type="text" name="timesheetId" required> 

        <label for="timesheetDate">Timesheet Date:</label>
        <input type="date" name="timesheetDate" required>

        <label for="timesheetDetails">Details:</label>
        <input type="text" name="timesheetDetails" required>

        <label for="emp_id">Employee ID:</label>
        <input type="number" name="emp_id" required>
        <button type="submit" name="addTimesheet">Add Timesheet</button>
    </form>

    <!-- Display success or error messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <script>
        // JavaScript for form validation
        document.querySelector('form').onsubmit = function(event) {
            const timesheetId = document.querySelector('[name="timesheetId"]').value;
            const timesheetDate = document.querySelector('[name="timesheetDate"]').value;
            const details = document.querySelector('[name="timesheetDetails"]').value;
            const emp_id = document.querySelector('[name="emp_id"]').value; 

            // Ensure that required fields are not empty
            if (!timesheetId || !timesheetDate || !details || !emp_id) {
                alert('Please fill out all required fields.');
                event.preventDefault();
            }
        };
    </script>
</div>

</body>
</html>
