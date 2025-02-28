<?php
include 'config.php'; 

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addDeliveryPartner'])) {
        // Get the input values
        $id = $_POST['delivery_partner_id'];
        $name = $_POST['delivery_partner_name'];
        $phone = $_POST['delivery_partner_tel'];

        // SQL query to insert the delivery partner data
        $sql = "INSERT INTO delivery_partner (Delivery_Partner_Id, Delivery_Partner_Name, Delivery_Partner_Tel) 
                VALUES (?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);
        
        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sss", $id, $name, $phone);
            
            // Execute the query
            if ($stmt->execute()) {
                // Redirect after successful addition
                header("Location: dlvrprtview.php"); // Change to your delivery partner table view page
                exit();
            } else {
                $error = "Error adding delivery partner: " . $stmt->error;
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
    <title>Add Delivery Partner</title>
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
        <h1>Delivery Partner Management</h1>
    </div>

    <form method="POST">
        <label for="delivery_partner_id">Partner ID:</label>
        <input type="text" name="delivery_partner_id" required>
        
        <label for="delivery_partner_name">Name:</label>
        <input type="text" name="delivery_partner_name" required>
        
        <label for="delivery_partner_tel">Phone No:</label>
        <input type="text" name="delivery_partner_tel" required>
        
        <button type="submit" name="addDeliveryPartner">Add Delivery Partner</button>
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
            const id = document.querySelector('[name="delivery_partner_id"]').value;
            const name = document.querySelector('[name="delivery_partner_name"]').value;
            if (!id || !name) {
                alert('Please fill out all fields.');
                event.preventDefault();
            }
        };
    </script>
</div>

</body>
</html>
