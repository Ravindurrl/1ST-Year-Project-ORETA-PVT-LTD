<?php
include 'config.php'; 

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addSupplier'])) {
        // Get the input values
        $id = $_POST['suppl_id'];
        $name = $_POST['suppl_name'];
        $tel = $_POST['suppl_tel'];
        $address = $_POST['suppl_address'];

        // Validate input fields
        if (empty($id) || empty($name) || empty($tel) || empty($address)) {
            $error = "Please fill out all required fields.";
        } else {
            // SQL query to insert the supplier data
            $sql = "INSERT INTO supplier (suppl_id, suppl_name, suppl_tel, suppl_address) 
                    VALUES (?, ?, ?, ?)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Check if the preparation is successful
            if ($stmt === false) {
                $error = "Error preparing statement: " . $conn->error;
            } else {
                // Bind parameters to the prepared statement
                $stmt->bind_param("ssss", $id, $name, $tel, $address);

                // Execute the query
                if ($stmt->execute()) {
                    // Redirect after successful addition
                    $success = "Supplier added successfully!";
                    header("Location: suppliermngview.php"); 
                    exit();
                } else {
                    $error = "Error adding supplier: " . $stmt->error;
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
    <title>Add Supplier</title>
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
        <h1>Add Supplier</h1>
    </div>

    <!-- Form to add a new supplier -->
    <form method="POST">
        <label for="suppl_id">Supplier ID:</label>
        <input type="text" name="suppl_id" required>
        
        <label for="suppl_name">Name:</label>
        <input type="text" name="suppl_name" required>
        
        <label for="suppl_tel">Phone No:</label>
        <input type="text" name="suppl_tel" required>
        
        <label for="suppl_address">Address:</label>
        <input type="text" name="suppl_address" required>

        <button type="submit" name="addSupplier">Add Supplier</button>
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
            const supplId = document.querySelector('[name="suppl_id"]').value;
            const name = document.querySelector('[name="suppl_name"]').value;
            const phone = document.querySelector('[name="suppl_tel"]').value;
            const address = document.querySelector('[name="suppl_address"]').value;

            // Ensure that required fields are not empty
            if (!supplId || !name || !phone || !address) {
                alert('Please fill out all required fields.');
                event.preventDefault();
            }
        };
    </script>
</div>

</body>
</html>
