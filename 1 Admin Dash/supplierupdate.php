<?php
include 'config.php'; 

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateSupplier'])) {
        // Get the input values
        $id = $_POST['suppl_id'];
        $name = $_POST['suppl_name'];
        $tel = $_POST['suppl_tel'];
        $address = $_POST['suppl_address'];

        // SQL query to update the supplier data
        $sql = "UPDATE supplier 
                SET suppl_name = ?, suppl_tel = ?, suppl_address = ? 
                WHERE suppl_id = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("ssss", $name, $tel, $address, $id);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Supplier updated successfully!";
                header("Location: suppliermngview.php"); 
                exit();
            } else {
                $error = "Error updating supplier: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch the supplier details for the given ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM supplier WHERE suppl_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $supplier = $result->fetch_assoc();
    } else {
        $error = "Supplier not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <title>Update Supplier</title>
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
        <h1>Update Supplier</h1>
    </div>

    <!-- Display Error/Success Messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Supplier Update Form -->
    <?php if (isset($supplier)): ?>
        <form method="POST">
            <label for="suppl_id">Supplier ID:</label>
            <input type="text" name="suppl_id" value="<?php echo $supplier['suppl_id']; ?>" readonly>
            
            <label for="suppl_name">Name:</label>
            <input type="text" name="suppl_name" value="<?php echo $supplier['suppl_name']; ?>" required>
            
            <label for="suppl_tel">Telephone:</label>
            <input type="text" name="suppl_tel" value="<?php echo $supplier['suppl_tel']; ?>" required>
            
            <label for="suppl_address">Address:</label>
            <input type="text" name="suppl_address" value="<?php echo $supplier['suppl_address']; ?>" required>

            <button type="submit" name="updateSupplier">Update Supplier</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
