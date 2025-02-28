<?php
include 'config.php'; 
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addProduct'])) {
        
        $productID = $_POST['productID']; 
        $productName = $_POST['productName'];
        $productType = $_POST['productType'];
        $productPrice = $_POST['productPrice'];
        $productQuantity = $_POST['productQuantity'];
        $sellDate = $_POST['sellDate'];
        $productDescription = $_POST['productDescription'];

        // SQL query to insert the product data
        $sql = "INSERT INTO products (ProductID, ProductName, ProductType, ProductPrice, ProductQuantity, SellDate, ProductDescription) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sssdiss", $productID, $productName, $productType, $productPrice, $productQuantity, $sellDate, $productDescription);

            // Execute the query
            if ($stmt->execute()) {
                // Success
                $success = "Product added successfully!";
                header("Location: viewproducts.php"); 
                exit();
            } else {
                // Error
                $error = "Error adding product: " . $stmt->error;
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
    <title>Add Product</title>
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
    <style>
    /* Form styling */
    form {
        display: grid;
        gap: 10px;
        column-width: 20px;
    }</style>
    <!-- Product Add Form -->
    <div class="main-content">
        <h1>Add Products details </h1>
        <form method="POST">
            <label for="productID">Product ID</label>
            <input type="text" name="productID" placeholder="Leave empty for auto-increment" /><br>

            <label for="productName">Product Name</label>
            <input type="text" name="productName" required /><br>

            <label for="productType">Product Type</label>
            <input type="text" name="productType" required /><br>

            <label for="productPrice">Product Price</label>
            <input type="number" name="productPrice" step="0.01" required /><br>

            <label for="productQuantity">Product Quantity</label>
            <input type="number" name="productQuantity" required /><br>

            <label for="sellDate">Sell Date</label>
            <input type="date" name="sellDate" required /><br>

            <label for="productDescription">Product Description</label>
            <textarea name="productDescription" required></textarea><br>

            <button type="submit" name="addProduct">Save Product</button>
        </form>
    </div>
</div>

</body>
</html>
