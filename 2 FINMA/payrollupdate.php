<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get the updated payroll data
    $payrollid = $_POST['payrollid'];
    $basicsalary = $_POST['basicsalary']; 
    $otamount = $_POST['otamount'];
    $leavededuction = $_POST['leavededuction'];
    $epfamount = $_POST['epfamount'];
    $etfamount = $_POST['etfamount'];
    $bonusamount = $_POST['bonusamount'];
    $allowance = $_POST['allowance'];

  
    $totalamount = $basicsalary + $otamount + $bonusamount + $allowance - ($leavededuction + $epfamount + $etfamount);

    // Update query
    $sql = "UPDATE payroll SET otamount = ?, leavededuction = ?, epfamount = ?, etfamount = ?, 
            bonusamount = ?, allowance = ?, totamount = ? WHERE payrollid = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Check for errors in the query preparation
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    // Bind the parameters
    $stmt->bind_param('dddddddi', $otamount, $leavededuction, $epfamount, $etfamount, 
                                   $bonusamount, $allowance, $totalamount, $payrollid);

    if ($stmt->execute()) {
        echo "Payroll updated successfully!";
        header("Location: payroll.php"); 
        exit();
    } else {
        // Output the error if the query fails
        echo "Error updating payroll: " . $stmt->error;
    }
}

// Fetch the current payroll data
if (isset($_GET['id'])) {
    $payrollid = $_GET['id'];
    $sql = "SELECT * FROM payroll WHERE payrollid = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Check for errors in the query preparation
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    $stmt->bind_param('i', $payrollid);
    $stmt->execute();
    $result = $stmt->get_result();
    $payroll = $result->fetch_assoc();

    if (!$payroll) {
        echo "Payroll record not found.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Payroll</title>
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
    <style> 
    
    /* Form styling */
    form {
        display: grid;
        gap: 10px;
    }
        </style>
        <h1>Update Payroll</h1>
        <form method="POST">
            <input type="hidden" name="payrollid" value="<?php echo htmlspecialchars($payroll['payrollid']); ?>">

            <label for="basicsalary">Basic Salary:</label>
            <input type="number" step="0.01" id="basicsalary" name="basicsalary" value="<?php echo htmlspecialchars($payroll['basicsalary']); ?>" required>

            <label for="otamount">Overtime Amount:</label>
            <input type="number" step="0.01" id="otamount" name="otamount" value="<?php echo htmlspecialchars($payroll['otamount']); ?>" required>

            <label for="leavededuction">Leave Deduction:</label>
            <input type="number" step="0.01" id="leavededuction" name="leavededuction" value="<?php echo htmlspecialchars($payroll['leavededuction']); ?>" required>

            <label for="epfamount">EPF Amount:</label>
            <input type="number" step="0.01" id="epfamount" name="epfamount" value="<?php echo htmlspecialchars($payroll['epfamount']); ?>" required>

            <label for="etfamount">ETF Amount:</label>
            <input type="number" step="0.01" id="etfamount" name="etfamount" value="<?php echo htmlspecialchars($payroll['etfamount']); ?>" required>

            <label for="bonusamount">Bonus Amount:</label>
            <input type="number" step="0.01" id="bonusamount" name="bonusamount" value="<?php echo htmlspecialchars($payroll['bonusamount']); ?>" required>

            <label for="allowance">Allowance:</label>
            <input type="number" step="0.01" id="allowance" name="allowance" value="<?php echo htmlspecialchars($payroll['allowance']); ?>" required>

            <label for="totamount">Total Amount:</label>
            <input type="number" step="0.01" id="totamount" name="totamount" value="<?php echo htmlspecialchars($payroll['totamount']); ?>" readonly>

            <button type="submit">Update Payroll</button>
        </form>
    </div>
</body>
</html>
