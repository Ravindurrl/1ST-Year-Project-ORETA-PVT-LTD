<?php
include 'config.php';

$error = $success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addPayroll'])) {
        // Get the input values from the form
        $emp_id = $_POST['emp_id'];
        $payrolldate = $_POST['payrolldate'];
        $basicsalary = $_POST['basicsalary'];  // New field for basic salary
        $otamount = $_POST['otamount'];
        $leavededuction = $_POST['leavededuction'];
        $epfamount = $_POST['epfamount'];
        $etfamount = $_POST['etfamount'];
        $bonusamount = $_POST['bonusamount'];
        $allowance = $_POST['allowance'];

        // Validate inputs
        if (empty($emp_id) || empty($payrolldate) || empty($basicsalary) || empty($otamount) || empty($leavededuction) || empty($epfamount) || empty($etfamount) || empty($bonusamount) || empty($allowance)) {
            $error = "All fields are required.";
        } else {
            // Perform payroll calculation for total amount
            $totalamount = $basicsalary + $otamount + $bonusamount + $allowance - ($leavededuction + $epfamount + $etfamount);

            // Insert payroll data into database
            $sql = "INSERT INTO payroll (emp_id, payrolldate, basicsalary, otamount, leavededuction, epfamount, etfamount, bonusamount, allowance, totamount) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Check if the preparation is successful
            if ($stmt === false) {
                $error = "Error preparing statement: " . $conn->error;
            } else {
                // Bind parameters to the prepared statement
                $stmt->bind_param("isdddddddd", $emp_id, $payrolldate, $basicsalary, $otamount, $leavededuction, $epfamount, $etfamount, $bonusamount, $allowance, $totalamount);

                // Execute the query
                if ($stmt->execute()) {
                    $success = "Payroll added successfully!";
                    // Redirect to the payroll view page after successful addition
                    header("Location: payroll.php");
                    exit();
                } else {
                    $error = "Error adding payroll: " . $stmt->error;
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
    <title>Add Payroll</title>
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>

  <!-- Sidebar Navigation -->
  <div class="sidebar">
        <h2>Finance Manager</h2>
        <ul class="sidebar-links">
            <li><a href="finpaymnt.php">Payment Management</a></li>
            <li><a href="bugtview.php">Budget & Investment</a></li>
            <li><a href="projectview.php">Calculate Project Cost</a></li>
            <li><a href="report-generation.php">Generate Project Report</a></li>
            <li><a href="deliverycostview.php">Calculate Delivery Cost</a></li>
            <li><a href="salaryview.php">Calculate Employee Salary</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="fmlogout.php" class="logout-btn">Logout</a>
    </div>

<div class="container">
    <h1>Add New Payroll</h1>

    <!-- Display Success/Error Messages -->
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
    <form action="payrolladd.php" method="post">
        <label for="emp_id">Employee ID</label>
        <input type="text" id="emp_id" name="emp_id" required>

        <label for="payrolldate">Payroll Date</label>
        <input type="date" id="payrolldate" name="payrolldate" required>

        <label for="basicsalary">Basic Salary</label>
        <input type="number" id="basicsalary" name="basicsalary" step="0.01" required>

        <label for="otamount">OT Amount</label>
        <input type="number" id="otamount" name="otamount" step="0.01" required>

        <label for="leavededuction">Leave Deduction</label>
        <input type="number" id="leavededuction" name="leavededuction" step="0.01" required>

        <label for="epfamount">EPF Amount</label>
        <input type="number" id="epfamount" name="epfamount" step="0.01" required>

        <label for="etfamount">ETF Amount</label>
        <input type="number" id="etfamount" name="etfamount" step="0.01" required>

        <label for="bonusamount">Bonus Amount</label>
        <input type="number" id="bonusamount" name="bonusamount" step="0.01" required>

        <label for="allowance">Allowances</label>
        <input type="number" id="allowance" name="allowance" step="0.01" required>

        <button type="submit" name="addPayroll">Save Payroll</button>
    </form>
</div>

</body>
</html>
