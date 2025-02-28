<?php
include 'config.php';

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateProductRequest'])) {
        // Get the input values
        $productRequestId = $_POST['productRequestId'];
        $productQuantity = $_POST['productQuantity'];
        $productValue = $_POST['productValue'];
        $productType = $_POST['productType'];

        // SQL query to update the product request data
        $sql = "UPDATE productrequests 
                SET product_quantity = ?, product_value = ?, product_type = ? 
                WHERE product_request_id = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("iiis", $productQuantity, $productValue, $productType, $productRequestId);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Product request updated successfully!";
                header("Location: productreq.php");
                exit();
            } else {
                $error = "Error updating product request: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch the product request details for the given ID
if (isset($_GET['id'])) {
    $productRequestId = $_GET['id'];
    $sql = "SELECT * FROM ProductRequests WHERE product_request_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productRequestId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $productRequest = $result->fetch_assoc();
    } else {
        $error = "Product request not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css"> 
    <title>Update Product Request</title>
</head>
<body>

<!-- Sidebar Navigation -->
<div class="sidebar">
        <h2>Product Management</h2>
        <ul class="sidebar-links">
            <li><a href="productreqview.php">Product Requests</a></li>
            <li><a href="orders.php">Orders</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="splogout.php" class="logout-btn">Logout</a>
</div>

<div class="container">
    <div class="profile-header">
        <h1>Update Product Request</h1>
    </div>

    <!-- Display Error/Success Messages -->
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

    <!-- Product Request Update Form -->
    <?php if (isset($productRequest)): ?>
        <form method="POST">
            <label for="productRequestId">Product Request ID:</label>
            <input type="text" name="productRequestId" value="<?php echo $productRequest['product_request_id']; ?>" readonly>
            
            <label for="productQuantity">Product Quantity:</label>
            <input type="number" name="productQuantity" value="<?php echo $productRequest['product_quantity']; ?>" required>
            
            <label for="productValue">Product Value:</label>
            <input type="number" name="productValue" step="0.01" value="<?php echo $productRequest['product_value']; ?>" required>
            
            <label for="productType">Product Type:</label>
            <input type="text" name="productType" value="<?php echo $productRequest['product_type']; ?>" required>

            <button type="submit" name="updateProductRequest">Update Product Request</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
