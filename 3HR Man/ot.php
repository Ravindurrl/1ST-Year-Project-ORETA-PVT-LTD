<?php
include 'config.php'; 

$sql = "SELECT * FROM OT";  
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HR Manager - Overtime Management</title>

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
    <h1>Overtime (OT) Records</h1>

    <!-- Success/Error Messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Overtime Records Table -->
    <style>
        /* Table styles with hover effect */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
    
    </style>

    <table id="otTable">
        <thead>
            <tr>
                <th>OT ID</th>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>OT Date</th>
                <th>Overtime Hours</th>
                <th>OT Salary</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['OTID'] . "</td>";
                    echo "<td>" . $row['emp_id'] . "</td>";
                    echo "<td>" . $row['EmployeeName'] . "</td>";
                    echo "<td>" . $row['OTDate'] . "</td>";
                    echo "<td>" . $row['OvertimeHours'] . "</td>";
                    echo "<td>" . $row['OTAmount'] . "</td>";
                    echo "<td>
                            <button onclick=\"window.location.href='ot_update.php?id=" . $row['OTID'] . "'\">Edit</button>
                            <button onclick=\"if(confirm('Are you sure you want to delete this overtime record?')) window.location.href='ot_delete.php?id=" . $row['OTID'] . "';\">Delete</button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No overtime records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <button onclick="window.location.href='ot_add.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
        Add New Overtime Record
    </button>
</div>

</body>
</html>
