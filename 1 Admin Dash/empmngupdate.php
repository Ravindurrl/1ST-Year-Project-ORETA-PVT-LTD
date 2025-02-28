<?php
include 'config.php'; 

$error = $success = "";

// Handle form submission for updating the employee
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateEmployee'])) {
        // Get the input values
        $id = $_POST['emp_id'];
        $name = $_POST['emp_name'];
        $phone = $_POST['emp_tel'];
        $dob = $_POST['emp_dob'];
        $nic = $_POST['NIC_no'];
        $email = $_POST['emp_email'];

        // SQL query to update the employee data
        $sql = "UPDATE employee 
                SET emp_name = ?, emp_tel = ?, emp_dob = ?, NIC_no = ?, emp_email = ? 
                WHERE emp_id = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("ssssss", $name, $phone, $dob, $nic, $email, $id);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Employee updated successfully!";
                header("Location: empmngview.php"); // Redirect to employee view page
                exit();
            } else {
                $error = "Error updating employee: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch the employee details for the given ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM employee WHERE emp_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        $error = "Employee not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <title>Update Employee</title>
</head>
<body>
  <!-- Sidebar Navigation -->
  <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul class="sidebar-links"> 
            <li><a href="adm.html">Dashboard</a></li>
            <li><a href="cstmngview.php">Customers</a></li>
            <li><a href="empmngview.php">Employees</a></li>
            <li><a href="Supevisorviewphp.php">Supervisors</a></li>
            <li><a href="managerview.php">Managers</a></li>
            <li><a href="suppliermngview.php">Suppliers</a></li>
            <li><a href="dlvrprtview.php">Delivery Partners</a></li>
            <li><a href="generateDiscount.php">Discounts</a></li>
        </ul>
        <a href="admlogout.php" class="logout-btn">Logout</a>
        
       
    </div>
<div class="container">
    <div class="profile-header">
        <h1>Update Employee</h1>
    </div>

    <!-- Display Error/Success Messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Employee Update Form -->
    <?php if (isset($employee)): ?>
        <form method="POST">
            <label for="emp_id">Employee ID:</label>
            <input type="text" name="emp_id" value="<?php echo $employee['emp_id']; ?>" readonly>
            
            <label for="emp_name">Name:</label>
            <input type="text" name="emp_name" value="<?php echo $employee['emp_name']; ?>" required>
            
            <label for="emp_tel">Phone No:</label>
            <input type="text" name="emp_tel" value="<?php echo $employee['emp_tel']; ?>" required>
            
            <label for="emp_dob">Date of Birth:</label>
            <input type="date" name="emp_dob" value="<?php echo $employee['emp_dob']; ?>" required>
            
            <label for="NIC_no">NIC Number:</label>
            <input type="text" name="NIC_no" value="<?php echo $employee['NIC_no']; ?>" required>
            
            <label for="emp_email">Email:</label>
            <input type="email" name="emp_email" value="<?php echo $employee['emp_email']; ?>">

            <button type="submit" name="updateEmployee">Update Employee</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
