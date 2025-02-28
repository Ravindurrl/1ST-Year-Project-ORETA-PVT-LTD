<?php
include 'config.php'; 
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addInventory'])) {
        // Get the input values from the form
        $inventoryID = $_POST['inventoryID'];
        $inPrice = $_POST['inPrice'];
        $inQuantity = $_POST['inQuantity'];  
        $inProductType = $_POST['inProductType'];                 

        // SQL query to insert the inventory data
        $sql = "INSERT INTO Inventory (InventoryID, INPrice, INQuantity, INProductType) 
                VALUES (?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("idid", $inventoryID, $inPrice, $inQuantity, $inProductType);

            // Execute the query
            if ($stmt->execute()) {
                // Success
                $success = "Inventory item added successfully!";
                header("Location: viewinventory.php"); 
                exit();
            } else {
                // Error
                $error = "Error adding inventory item: " . $stmt->error;
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
    <title>Add Inventory Item</title>
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar">
    <h2>Salesperson Dashboard</h2>
    <ul class="sidebar-links">
        <li><a href="viewinventory.php">View Inventory</a></li>
        <li><a href="sendorder.php">Send Order to Delivery</a></li>
        <li><a href="sales-target.php">Sales Target</a></li>
        <li><a href="orderinvoice.php">View Order Invoice</a></li>
    </ul>
    <!-- Logout Button -->
    <a href="slplogout.php" class="logout-btn">Logout</a>
</div>


    <!-- Success/Error Messages -->
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
    <!-- Inventory Add Form -->
    <div class="main-content">
        <h1>Add New Inventory Item</h1>
        <form method="POST">
            <label for="inventoryID">Inventory ID</label>
            <input type="number" name="inventoryID" placeholder="Enter inventory ID (if not auto-increment)" min="1" required><br>

            <label for="inPrice">Price</label>
            <input type="number" step="0.01" name="inPrice" placeholder="Enter item price" required><br>

            <label for="inQuantity">Quantity</label>
            <input type="number" name="inQuantity" placeholder="Enter item quantity" required><br>

            <label for="inProductType">Product Type</label>
            <input type="text" name="inProductType" placeholder="Enter product type" required><br>

            <button type="submit" name="addInventory">Save Inventory Item</button>
        </form>
    </div>
</div>

</body>
</html>
