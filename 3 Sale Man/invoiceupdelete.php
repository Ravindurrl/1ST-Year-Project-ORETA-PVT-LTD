<?php
include 'config.php'; 
$error = $success = "";

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $orderID = $_GET['id'];

    // SQL query to delete the order
    $sql = "DELETE FROM `Order` WHERE order_id = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Check if the preparation is successful
    if ($stmt === false) {
        $error = "Error preparing statement: " . $conn->error;
    } else {
        // Bind the parameter to the prepared statement
        $stmt->bind_param("i", $orderID);

        // Execute the query
        if ($stmt->execute()) {
            // Success
            $success = "Order deleted successfully!";
            header("Location: vieworders.php"); // Redirect to view orders page
            exit();
        } else {
            // Error
            $error = "Error deleting order: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
} else {
    $error = "Order ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Order</title>
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

    <div class="main-content">
        <h1>Delete Order</h1>
        <p>Are you sure you want to delete this order?</p>
        <form method="GET">
            <input type="hidden" name="id" value="<?php echo $orderID; ?>">
            <button type="submit">Confirm Deletion</button>
        </form>
    </div>
</div>

</body>
</html>
