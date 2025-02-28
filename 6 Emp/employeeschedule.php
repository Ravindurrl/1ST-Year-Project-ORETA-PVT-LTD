<?php 
include 'config.php';

$error = $success = "";

// Check if the form is submitted for status update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted status data
    $statuses = $_POST['status'];

    // Update each schedule's status in the database
    foreach ($statuses as $scheduleId => $status) {
        $sql = "UPDATE schedule SET Status = ? WHERE scheduleId = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("si", $status, $scheduleId);
            $stmt->execute();
        }
    }

    // Set success message and reload the page to reflect changes
    $success = "Statuses updated successfully!";
}

// Fetch schedules from the database
$sql = "SELECT * FROM schedule";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <title>Employee Schedule Management</title>
</head>
<body>


<div class="sidebar">
    <h2>Employee Dashboard</h2>
    <ul class="sidebar-links">
        <li><a href="attendence.php">Update Attendance</a></li>
        <li><a href="empleave.php">View Leaves</a></li>
        <li><a href="payroll.php">Payroll Information</a></li>
        <li><a href="employeeschedule.php">Track Schedule</a></li>
        <li><a href="timesheets.php">Submit Timesheet</a></li>
    </ul>
    <a href="login.html" class="logout-btn">Logout</a>
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
    <form action="employeeschedule.php" method="post">
        <table>
            <thead>
                <tr>
                    <th>Schedule ID</th>
                    <th>Task Type</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Employee ID</th>
                    <th>Status</th>
                    <th>Selected Status</th> <!-- New column for displaying selected status -->
                    <th>Update</th> <!-- Update button column -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Default status if none is set in the database
                        $status = !empty($row['Status']) ? $row['Status'] : 'Not Yet';
                        echo "<tr>";
                        echo "<td>" . $row['scheduleId'] . "</td>";
                        echo "<td>" . $row['taskType'] . "</td>";
                        echo "<td>" . $row['scheduleDescription'] . "</td>";
                        echo "<td>" . $row['scheduleStartDate'] . "</td>";
                        echo "<td>" . $row['scheduleEndDate'] . "</td>";
                        echo "<td>" . $row['emp_id'] . "</td>";
                        echo "<td>
                                <select name='status[" . $row['scheduleId'] . "]'>
                                    <option value='Complete'" . ($status === 'Complete' ? " selected" : "") . ">Complete</option>
                                    <option value='Not Yet'" . ($status === 'Not Yet' ? " selected" : "") . ">Not Yet</option>
                                </select>
                              </td>";
                        echo "<td>
                                <span>" . $status . "</span> <!-- Display the current selected status -->
                              </td>";
                        echo "<td>
                                <button type='submit' name='update_status[" . $row['scheduleId'] . "]' style='padding: 5px 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;'>Update</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No schedules found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- This button updates the status for all schedules -->
        <button type="submit" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
            Update All Statuses
        </button>
    </form>
</div>

</body>
</html>
