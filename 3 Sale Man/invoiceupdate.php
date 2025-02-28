<?php
include 'config.php'; 


$error = $success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateOrder'])) {
       
        $orderID = $_POST['orderID'];
        $orderName = $_POST['orderName'];
        $orderStatus = $_POST['orderStatus'];
        $discount = $_POST['discount'];
        $orderQuantity = $_POST['orderQuantity'];
        $orderValue = $_POST['orderValue'];
        $orderDate = $_POST['orderDate'];
        $cusID = $_POST['cusID'];

        // SQL query to update the order data
        $sql = "UPDATE `Order` 
                SET order_name = ?, order_status = ?, discount = ?, order_quantity = ?, order_value = ?, order_date = ?, cus_id = ? 
                WHERE order_id = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("ssiisssi", $orderName, $orderStatus, $discount, $orderQuantity, $orderValue, $orderDate, $cusID, $orderID);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Order updated successfully!";
                header("Location: vieworders.php");
                exit();
            } else {
                $error = "Error updating order: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch the order data to pre-fill the form
if (isset($_GET['id'])) {
    $orderID = $_GET['id'];
    $sql = "SELECT * FROM `Order` WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $orderName = $row['order_name'];
        $orderStatus = $row['order_status'];
        $discount = $row['discount'];
        $orderQuantity = $row['order_quantity'];
        $orderValue = $row['order_value'];
        $orderDate = $row['order_date'];
        $cusID = $row['cus_id'];
    } else {
        $error = "Order not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Order</title>

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

<div class="container">
    <h1>Update Order</h1>

    <!-- Success/Error Messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Order Update Form -->
    <form method="POST">
        <input type="hidden" name="orderID" value="<?php echo $orderID; ?>">

        <label for="orderName">Order Name</label>
        <input type="text" name="orderName" value="<?php echo $orderName; ?>" maxlength="20" required>

        <label for="orderStatus">Order Status</label>
        <input type="text" name="orderStatus" value="<?php echo $orderStatus; ?>" maxlength="20" required>

        <label for="discount">Discount</label>
        <input type="number" step="0.01" name="discount" value="<?php echo $discount; ?>" required>

        <label for="orderQuantity">Order Quantity</label>
        <input type="number" name="orderQuantity" value="<?php echo $orderQuantity; ?>" required>

        <label for="orderValue">Order Value</label>
        <input type="number" step="0.01" name="orderValue" value="<?php echo $orderValue; ?>" required>

        <label for="orderDate">Order Date</label>
        <input type="date" name="orderDate" value="<?php echo $orderDate; ?>" required>

        <label for="cusID">Customer ID</label>
        <input type="text" name="cusID" value="<?php echo $cusID; ?>" maxlength="10" required>

        <button type="submit" name="updateOrder">Update Order</button>
    </form>
</div>

</body>
</html>
