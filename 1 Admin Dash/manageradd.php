<?php

include 'config.php';


$error = $success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the add manager form was submitted
    if (isset($_POST['addManager'])) {
        // Get the input values from the form
        $name = $_POST['name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $birthday = $_POST['birthday'];
        $telephone = $_POST['telephone'];
        $salary = $_POST['salary'];
        $department = $_POST['department'];
        $nic = $_POST['nic'];

        // SQL query to insert the manager data
        $sql = "INSERT INTO manager (name, address, email, birthday, telephone, salary, department, nic) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sssssdss", $name, $address, $email, $birthday, $telephone, $salary, $department, $nic);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect after successful update
                header("Location: managerview.php"); 
                exit();
            } else {
                $error = "Error adding manager: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Manager</title>
    <link rel="stylesheet" href="Supevisoradd.css">
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
        <h1>Add Manager</h1>

        <!-- Display Success/Error Messages -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Add Manager Form -->
        <form action="" method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="birthday">Birth Date</label>
            <input type="date" id="birthday" name="birthday" required>

            <label for="telephone">Telephone</label>
            <input type="tel" id="telephone" name="telephone" required>

            <label for="salary">Salary</label>
            <input type="number" id="salary" name="salary" step="0.01" required>

            <label for="department">Department</label>
            <input type="text" id="department" name="department" required>

            <label for="nic">NIC</label>
            <input type="text" id="nic" name="nic" required>

            <button type="submit" name="addManager">Add Manager</button>
        </form>
    </div>
</body>
</html>
