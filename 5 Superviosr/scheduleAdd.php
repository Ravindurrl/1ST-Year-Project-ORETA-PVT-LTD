<?php
include 'config.php'; 

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addSchedule'])) {
        // Get the input values
        $scheduleId = $_POST['scheduleId'];
        $taskType = $_POST['taskType'];
        $scheduleDescription = $_POST['scheduleDescription'];
        $scheduleStartDate = $_POST['scheduleStartDate'];
        $scheduleEndDate = $_POST['scheduleEndDate'];
        $empId = $_POST['empId'];

        // Validate input fields
        if (empty($scheduleId) || empty($taskType) || empty($scheduleDescription) || empty($scheduleStartDate) || empty($scheduleEndDate) || empty($empId)) {
            $error = "Please fill out all required fields.";
        } else {
            // SQL query to insert the schedule data
            $sql = "INSERT INTO schedule (scheduleId, taskType, scheduleDescription, scheduleStartDate, scheduleEndDate, emp_id) 
                    VALUES (?, ?, ?, ?, ?, ?)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Check if the preparation is successful
            if ($stmt === false) {
                $error = "Error preparing statement: " . $conn->error;
            } else {
                // Bind parameters to the prepared statement
                $stmt->bind_param("sssssi", $scheduleId, $taskType, $scheduleDescription, $scheduleStartDate, $scheduleEndDate, $empId);

                // Execute the query
                if ($stmt->execute()) {
                    // Redirect after successful addition
                    $success = "Schedule added successfully!";
                    header("Location:employeeschedule.php");
                    exit();
                } else {
                    $error = "Error adding schedule: " . $stmt->error;
                }

                // Close the statement
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
    <title>Add Schedule</title>
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar">
        <h2>Supervisor Dashboard</h2>
        <ul class="sidebar-links">
            <li><a href="employeeschedule.php">Employee Schedule</a></li>
            <li><a href="supervisorleave.php">Leave Requests</a></li>
            <li><a href="timesheets.php">Timesheet Management</a></li>
            <li><a href="productreq.php">Product Requests</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="splogout.php" class="logout-btn">Logout</a>
    </div>
<div class="container">
    <div class="profile-header">
        <h1>Add Schedule</h1>
    </div>

    <!-- Form to add a new schedule -->
    <form method="POST">
        <label for="scheduleId">Schedule ID:</label>
        <input type="text" name="scheduleId" required>
        
        <label for="taskType">Task Type:</label>
        <input type="text" name="taskType" required>
        
        <label for="scheduleDescription">Description:</label>
        <input type="text" name="scheduleDescription" required>
        
        <label for="scheduleStartDate">Start Date:</label>
        <input type="date" name="scheduleStartDate" required>
        
        <label for="scheduleEndDate">End Date:</label>
        <input type="date" name="scheduleEndDate" required>
        
        <label for="empId">Employee ID:</label>
        <input type="number" name="empId" required>

        <button type="submit" name="addSchedule">Add Schedule</button>
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
            const scheduleId = document.querySelector('[name="scheduleId"]').value;
            const taskType = document.querySelector('[name="taskType"]').value;
            const description = document.querySelector('[name="scheduleDescription"]').value;
            const startDate = document.querySelector('[name="scheduleStartDate"]').value;
            const endDate = document.querySelector('[name="scheduleEndDate"]').value;
            const empId = document.querySelector('[name="empId"]').value;

            // Ensure that required fields are not empty
            if (!scheduleId || !taskType || !description || !startDate || !endDate || !empId) {
                alert('Please fill out all required fields.');
                event.preventDefault();
            }
        };
    </script>
</div>

</body>
</html>
