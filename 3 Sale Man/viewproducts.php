<?php 
include 'config.php'; 

// Query to get all product information
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Management</title>
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

    <div class="main-content">
        <h1>Product Management</h1>

        <!-- Success/Error Messages -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Product Table -->
        <table id="productTable">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Type</th>
                    <th>Product Price</th>
                    <th>Product Quantity</th>
                    <th>Sell Date</th>
                    <th>Product Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic rows will be inserted here -->
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Format the sell date
                        $sellDate = date('Y-m-d', strtotime($row['SellDate']));
                        echo "<tr>";
                        echo "<td>" . $row['ProductID'] . "</td>";
                        echo "<td>" . $row['ProductName'] . "</td>";
                        echo "<td>" . $row['ProductType'] . "</td>";
                        echo "<td>" . $row['ProductPrice'] . "</td>";
                        echo "<td>" . $row['ProductQuantity'] . "</td>";
                        echo "<td>" . $sellDate . "</td>";
                        echo "<td>" . $row['ProductDescription'] . "</td>";
                        echo "<td>
                                <button onclick=\"window.location.href='productupdate.php?id=" . $row['ProductID'] . "'\">Edit</button>
                                <button onclick=\"if(confirm('Are you sure you want to delete this product?')) window.location.href='productdelete.php?id=" . $row['ProductID'] . "';\">Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- New Button to Add Product -->
        <button onclick="window.location.href='productadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
            Add New Product
        </button>
    </div>
</div>

</body>
</html>
