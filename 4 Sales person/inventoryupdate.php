<?php
include 'config.php';

// Check if InventoryID is provided in the URL
if (isset($_GET['id'])) {
    $inventoryID = $_GET['id'];

    // Fetch existing inventory data
    $sql = "SELECT * FROM Inventory WHERE InventoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $inventoryID);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Fetch the current inventory data
            $row = $result->fetch_assoc();
            $inPrice = $row['INPrice'];
            $inQuantity = $row['INQuantity'];
            $inProductType = $row['INProductType'];
        } else {
            $error = "Inventory item not found.";
        }
    } else {
        $error = "Error fetching inventory: " . $stmt->error;
    }

    // Check if the form is submitted to update the inventory item
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $inPrice = $_POST['inPrice'];
        $inQuantity = $_POST['inQuantity'];
        $inProductType = $_POST['inProductType'];

        // SQL query to update the inventory data
        $sql = "UPDATE Inventory SET INPrice = ?, INQuantity = ?, INProductType = ? WHERE InventoryID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("diss", $inPrice, $inQuantity, $inProductType, $inventoryID);

        if ($stmt->execute()) {
            $success = "Inventory item updated successfully!";
            header("Location: viewinventory.php"); 
            exit();
        } else {
            $error = "Error updating inventory: " . $stmt->error;
        }
    }
} else {
    $error = "Inventory ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Inventory Item</title>
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>

 <!-- Sidebar Navigation -->
 <div class="sidebar">
        <h2>Salesperson Dashboard</h2>
        <ul class="sidebar-links">
            <li><a href="viewinventory.php">View Inventory</a></li>
            <li><a href="send-order.php">Send Order to Delivery</a></li>
            <li><a href="sales-target.php">Sales Target</a></li>
            <li><a href="orderinvoice.php">View Order Invoice</a></li>
            <li><a href="customerpayments.php">Customer Payments</a></li>
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
        column-width: 20px;
    }</style>
            <!-- Inventory Update Form -->
            <?php if (isset($inPrice)): ?>
                <form method="POST">
                    <label for="inPrice">Price</label>
                    <input type="number" name="inPrice" step="0.01" value="<?php echo $inPrice; ?>" required><br>

                    <label for="inQuantity">Quantity</label>
                    <input type="number" name="inQuantity" value="<?php echo $inQuantity; ?>" required><br>

                    <label for="inProductType">Product Type</label>
                    <input type="text" name="inProductType" value="<?php echo $inProductType; ?>" required><br>

                    <button type="submit">Update Inventory Item</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
