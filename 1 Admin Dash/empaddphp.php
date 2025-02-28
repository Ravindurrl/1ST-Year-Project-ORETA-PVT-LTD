<?php
include 'config.php'; 

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addEmployee'])) {
        // Get the input values
        $name = $_POST['emp_name'];
        $phone = $_POST['emp_tel'];
        $dob = $_POST['emp_dob'];
        $nic = $_POST['NIC_no'];
        $email = $_POST['emp_email'];

        // Validate input fields
        if (empty($name) || empty($phone) || empty($dob) || empty($nic)) {
            $error = "Please fill out all required fields.";
        } elseif (!preg_match('/^\d{10}$/', $phone)) {
            $error = "Phone number must be exactly 11 digits.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        } elseif (!preg_match('/^\d{13}$/', $nic)) {
            $error = "NIC must be exactly 13 digits.";
        } else {
            // SQL query to insert the employee data
            $sql = "INSERT INTO employee (emp_name, emp_tel, emp_dob, NIC_no, emp_email) 
                    VALUES (?, ?, ?, ?, ?)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Check if the preparation is successful
            if ($stmt === false) {
                $error = "Error preparing statement: " . $conn->error;
            } else {
                // Bind parameters to the prepared statement
                $stmt->bind_param("sssss", $name, $phone, $dob, $nic, $email);

                // Execute the query
                if ($stmt->execute()) {
                    // Redirect after successful addition
                    $success = "Employee added successfully!";
                    header("Location: empmngview.php"); // Change to your employee list view page
                    exit();
                } else {
                    $error = "Error adding employee: " . $stmt->error;
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
    <title>Add Employee</title>
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
        <h1>Add Employee</h1>
    </div>
    <style> 
/* Form styling */
form {
    display: grid;
    gap: 10px;
}
</style>

    <!-- Form to add a new employee -->
    <form method="POST">
        <label for="emp_name">Name:</label>
        <input type="text" name="emp_name" required>
        
        <label for="emp_tel">Phone No:</label>
        <input type="text" name="emp_tel" required>
        
        <label for="emp_dob">Date of Birth:</label>
        <input type="date" name="emp_dob" required>
        
        <label for="NIC_no">NIC Number:</label>
        <input type="text" name="NIC_no" required>
        
        <label for="emp_email">Email:</label>
        <input type="email" name="emp_email">

        <button type="submit" name="addEmployee">Add Employee</button>
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
            const phone = document.querySelector('[name="emp_tel"]').value;
            const email = document.querySelector('[name="emp_email"]').value;
            const nic = document.querySelector('[name="NIC_no"]').value;

            const phoneRegex = /^\d{10}$/;
            const nicRegex = /^\d{13}$/;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!phoneRegex.test(phone)) {
                alert('Phone number must be exactly 10 digits.');
                event.preventDefault();
            }

            if (!nicRegex.test(nic)) {
                alert('NIC must be exactly 13 digits.');
                event.preventDefault();
            }

            if (!emailRegex.test(email)) {
                alert('Invalid email format.');
                event.preventDefault();
            }
        };
    </script>
</div>

</body>
</html>
