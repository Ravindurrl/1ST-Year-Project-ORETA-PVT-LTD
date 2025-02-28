<?php
include 'config.php';
$error = $success = "";

// Check if the order ID is provided in the URL
if (isset($_GET['id'])) {
    $orderID = $_GET['id'];

    // SQL query to delete the sendorderdeli record
    $sql = "DELETE FROM sendorderdeli WHERE OrderID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderID);

    if ($stmt->execute()) {
        $success = "Order deleted successfully!";
        header("Location: send-order.php"); 
        exit();
    } else {
        $error = "Error deleting order: " . $stmt->error;
    }
} else {
    $error = "No order ID provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Send Order</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar">
    <h2>Salesperson Dashboard</h2>
    <ul class="sidebar-links">
        <li><a href="viewinventory.php">View Inventory</a></li>
        <li><a href="sendorder.php">Send Order to Delivery</a></li>
        <li><a href="vieworderinvoice.php">View Order Invoice</a></li>
    </ul>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<!-- Success/Error Messages -->
<?php if (!empty($error)): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <p class="success"><?php echo $success; ?></p>
<?php endif; ?>

<div class="main-content">
    <h1>Delete Send Order</h1>
    <p>Are you sure you want to delete the order with Order ID: <?php echo $orderID; ?>?</p>
    <a href="delete_sendorder.php?id=<?php echo $orderID; ?>" class="btn-danger">Yes, Delete</a>
    <a href="viewsendorder.php" class="btn-cancel">Cancel</a>
</div>

</body>
</html>
