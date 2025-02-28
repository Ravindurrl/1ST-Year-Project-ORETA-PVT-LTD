<?php
include 'config.php'; 

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addSupervisor'])) {
        // Get the input values
        $name = $_POST['sup_name'];
        $address = $_POST['sup_address'];
        $email = $_POST['sup_email'];
        $phoneNo = $_POST['sup_tel'];

        // SQL query to insert the supervisor data
        $sql = "INSERT INTO supervisor (sup_name, sup_address, sup_email, sup_tel) 
                VALUES (?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);
        
        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("ssss", $name, $address, $email, $phoneNo);
            
            // Execute the query
            if ($stmt->execute()) {
                // Redirect after successful update
                header("Location: Supevisorviewphp.php."); // Change to your supervisor table page
                exit();
            } else {
                $error = "Error adding supervisor: " . $stmt->error;
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
  <div class="profile-header">
                
                <div>
                    <h1>Supervisor Management</h1>
                </div>
            </div>


    <form method="POST">
        <label for="sup_id">Supervisor ID:</label>
        <input type="number" name="sup_id" required>
        
        <label for="sup_name">Name:</label>
        <input type="text" name="sup_name" required>
        
        <label for="sup_address">Address:</label>
        <input type="text" name="sup_address" required>
        
        <label for="sup_email">Email:</label>
        <input type="email" name="sup_email" required>

        <label for="sup_tel">Phone No:</label>
        <input type="text" name="sup_tel" required>
        
        <button type="submit" name="addSupervisor">Add Supervisor</button>
    </form>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <script>
        // JavaScript for form validation
        document.querySelector('form').onsubmit = function(event) {
            const id = document.querySelector('[name="sup_id"]').value;
            const name = document.querySelector('[name="sup_name"]').value;
            if (!id || !name) {
                alert('Please fill out all fields.');
                event.preventDefault();
            }
        };
    </script>
</body>
</html>
