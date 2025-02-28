<?php
include 'config.php';

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $productID = $_GET['id'];

    // Fetch existing product data
    $sql = "SELECT * FROM products WHERE ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Fetch the current product data
            $row = $result->fetch_assoc();
            $productName = $row['ProductName'];
            $productType = $row['ProductType'];
            $productPrice = $row['ProductPrice'];
            $productQuantity = $row['ProductQuantity'];
            $sellDate = $row['SellDate'];
            $productDescription = $row['ProductDescription'];
        } else {
            $error = "Product not found.";
        }
    } else {
        $error = "Error fetching product: " . $stmt->error;
    }

    // Check if the form is submitted to update the product
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productName = $_POST['productName'];
        $productType = $_POST['productType'];
        $productPrice = $_POST['productPrice'];
        $productQuantity = $_POST['productQuantity'];
        $sellDate = $_POST['sellDate'];
        $productDescription = $_POST['productDescription'];

        // SQL query to update the product data
        $sql = "UPDATE Products SET ProductName = ?, ProductType = ?, ProductPrice = ?, ProductQuantity = ?, SellDate = ?, ProductDescription = ? WHERE ProductID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdiss", $productName, $productType, $productPrice, $productQuantity, $sellDate, $productDescription, $productID);

        if ($stmt->execute()) {
            $success = "Product updated successfully!";
            header("Location: viewproducts.php"); 
            exit();
        } else {
            $error = "Error updating product: " . $stmt->error;
        }
    }
} else {
    $error = "Product ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Product</title>
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>
<div class="container">
    <div class="main-content">
        <h1>Update Product</h1>
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
        <style>
    /* Form styling */
    form {
        display: grid;
        gap: 10px;
        column-width: 20px;
    }</style>
        <!-- Product Update Form -->
        <?php if (isset($productName)): ?>
            <form method="POST">
                <label for="productName">Product Name</label>
                <input type="text" name="productName" value="<?php echo $productName; ?>" required><br>

                <label for="productType">Product Type</label>
                <input type="text" name="productType" value="<?php echo $productType; ?>" required><br>

                <label for="productPrice">Product Price</label>
                <input type="number" name="productPrice" step="0.01" value="<?php echo $productPrice; ?>" required><br>

                <label for="productQuantity">Product Quantity</label>
                <input type="number" name="productQuantity" value="<?php echo $productQuantity; ?>" required><br>

                <label for="sellDate">Sell Date</label>
                <input type="date" name="sellDate" value="<?php echo $sellDate; ?>" required><br>

                <label for="productDescription">Product Description</label>
                <textarea name="productDescription" required><?php echo $productDescription; ?></textarea><br>

                <button type="submit">Update Product</button>
            </form>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
