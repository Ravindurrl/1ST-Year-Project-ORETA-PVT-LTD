<?php
include 'config.php'; 

$error = $success = "";

// Handling schedule addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addSchedule'])) {
        // Get the input values
        $scheduleId = $_POST['scheduleId'];
        $taskType = $_POST['taskType'];
        $scheduleDescription = $_POST['scheduleDescription'];
        $scheduleStartDate = $_POST['scheduleStartDate'];
        $scheduleEndDate = $_POST['scheduleEndDate'];
        $empId = $_POST['emp_id'];

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
                $success = "Schedule added successfully!";
            } else {
                $error = "Error adding schedule: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch schedules from the database to display in a table
$sql = "SELECT * FROM schedule";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css"><br>
    <title>Employee Schedule Management</title><br>
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
        <h1>Employee Schedule Management</h1>
    </div>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Schedule List Table -->
    <h2>List of Schedules</h2>
    <table>
        <thead>
            <tr>
                <th>Schedule ID</th>
                <th>Task Type</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Employee ID</th>
                <th>Status</th> <!-- New Status Column -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    
                    $status = !empty($row['Status']) ? $row['Status'] : 'Not Yet';  
                    echo "<tr>";
                    echo "<td>" . $row['scheduleId'] . "</td>";
                    echo "<td>" . $row['taskType'] . "</td>";
                    echo "<td>" . $row['scheduleDescription'] . "</td>";
                    echo "<td>" . $row['scheduleStartDate'] . "</td>";
                    echo "<td>" . $row['scheduleEndDate'] . "</td>";
                    echo "<td>" . $row['emp_id'] . "</td>";
                    echo "<td>" . $status . "</td>"; 
                    echo "<td>
                            <button onclick=\"window.location.href='scheduleUpdate.php?id=" . $row['scheduleId'] . "'\">Edit</button>
                            <button onclick=\"if(confirm('Are you sure you want to delete this schedule?')) window.location.href='scheduleDelete.php?id=" . $row['scheduleId'] . "';\">Delete</button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No schedules found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Button styled with a link -->
    <button onclick="window.location.href='scheduleAdd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
        Add New Schedule
    </button>
</div>

</body>
</html>
