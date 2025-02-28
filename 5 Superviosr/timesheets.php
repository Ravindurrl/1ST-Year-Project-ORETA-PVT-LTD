<?php
include 'config.php';

// Query to fetch all timesheets
$sql = "SELECT * FROM timesheet";  
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Timesheet Management</title>

    <link rel="stylesheet" href="Supevisoradd.css"> 
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
    <div class="main-content">
        <h1>Timesheet List</h1>

        <!-- Success/Error Messages -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Timesheet Table -->
        <table id="timesheetTable">
            <thead>
                <tr>
                    <th>Timesheet ID</th>
                    <th>Timesheet Date</th>
                    <th>Details</th>
                    <th>Employee ID</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
               
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        
                        $status = isset($row['Status']) ? $row['Status'] : 'Not Yet';

                        echo "<tr>";
                        echo "<td>" . $row['timesheetId'] . "</td>"; 
                        echo "<td>" . $row['timesheetDate'] . "</td>";
                        echo "<td>" . $row['timesheetDetails'] . "</td>";
                        echo "<td>" . $row['emp_id'] . "</td>";
                        echo "<td>" . $status . "</td>";
                        echo "<td>
                                <button onclick=\"window.location.href='timesheetupdate.php?id=" . $row['timesheetId'] . "'\">Edit</button>
                                <button onclick=\"if(confirm('Are you sure you want to delete this timesheet?')) window.location.href='timesheetdelete.php?id=" . $row['timesheetId'] . "';\">Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No timesheets found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- New Button to Add Timesheet -->
        <button onclick="window.location.href='timesheetadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
            Add New Timesheet
        </button>
    </div>
</div>

</body>
</html>
