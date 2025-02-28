<?php

include 'config.php'; 
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addOrder'])) {
        // Get the input values from the form
        $orderID = $_POST['orderID'];
        $orderName = $_POST['orderName'];
        $orderStatus = $_POST['orderStatus'];
        $discount = $_POST['discount'];
        $orderQuantity = $_POST['orderQuantity'];
        $orderValue = $_POST['orderValue'];
        $orderDate = $_POST['orderDate'];
        $cusID = $_POST['cusID'];

        // SQL query to insert the order data
        $sql = "INSERT INTO `Order` (order_id, order_name, order_status, discount, order_quantity, order_value, order_date, cus_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sssiiiss", $orderID, $orderName, $orderStatus, $discount, $orderQuantity, $orderValue, $orderDate, $cusID);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect after successful addition
                header("Location:vieworders.php"); 
                exit();
            } else {
                $error = "Error adding order: " . $stmt->error;
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
    <title>Add Order</title>
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>
<div class="container">
   <!-- Sidebar Navigation -->
   <div class="sidebar">
        <h2>Sales & Marketing Manager</h2>
        <ul class="sidebar-links">
            <li><a href="viewsalesperson.php">View Sales Person</a></li>
            <li><a href="vieworders.php">View Orders</a></li>
            <li><a href="deliverypartner.php">View Delivery Partners</a></li>
            <li><a href="generateDiscount.php">Generate Discount</a></li>
            <li><a href="viewsalestarget.php">View Sales Target</a></li>
            <li><a href="viewproducts.php">View Products</a></li>
            <li><a href="generatebusinessplan.php">Generate Business Plan</a></li>
            <li><a href="viewinventory.php">View Inventory</a></li>
            <li><a href="eventview.php">View Event</a></li>

        </ul>
        <!-- Logout Button -->
        <a href="slmlogout.php" class="logout-btn">Logout</a>
    </div>
    <!-- Success/Error Messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>
    <div class="container">
    <h1>Add Order</h1>
    <style> 
    
/* Form styling */
form {
    display: grid;
    gap: 10px;
}
    </style>
    <!-- Order Add Form -->
    <form method="POST">
        <label for="orderID">Order ID</label>
        <input type="text" name="orderID" placeholder="Leave empty for auto-increment" maxlength="10"><br>

        <label for="orderName">Order Name</label>
        <input type="text" name="orderName" maxlength="20" required><br>

        <label for="orderStatus">Order Status</label>
        <input type="text" name="orderStatus" maxlength="20" required><br>

        <label for="discount">Discount</label>
        <input type="number" name="discount" step="0.01" required><br>

        <label for="orderQuantity">Order Quantity</label>
        <input type="number" name="orderQuantity" required><br>

        <label for="orderValue">Order Value</label>
        <input type="number" name="orderValue" step="0.01" required><br>

        <label for="orderDate">Order Date</label>
        <input type="date" name="orderDate" required><br>

        <label for="cusID">Customer ID</label>
        <input type="text" name="cusID" maxlength="10" required><br>

        <button type="submit" name="addOrder">Save Order</button>
    </form>
</div>

</body>
</html>
