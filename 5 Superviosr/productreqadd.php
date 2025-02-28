<?php
include 'config.php'; 

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addProductRequest'])) {
        // Get the input values
        $productRequestId = $_POST['productRequestId'];
        $productQuantity = $_POST['productQuantity'];
        $productValue = $_POST['productValue'];
        $productType = $_POST['productType'];

        // Validate input fields
        if (empty($productRequestId) || empty($productQuantity) || empty($productValue) || empty($productType)) {
            $error = "Please fill out all required fields.";
        } else {
            // SQL query to insert the product request data
            $sql = "INSERT INTO productrequests (product_request_id, product_quantity, product_value, product_type) 
                    VALUES (?, ?, ?, ?)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);

            // Check if the preparation is successful
            if ($stmt === false) {
                $error = "Error preparing statement: " . $conn->error;
            } else {
                // Bind parameters to the prepared statement
                $stmt->bind_param("iiis", $productRequestId, $productQuantity, $productValue, $productType);

                // Execute the query
                if ($stmt->execute()) {
                    // Redirect after successful addition
                    $success = "Product request added successfully!";
                    header("Location:productreq.php");
                    exit();
                } else {
                    $error = "Error adding product request: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <title>Add Product Request</title>
</head>
<body>
<!-- Sidebar Navigation -->
<div class="sidebar">
        <h2>Supervisor Dashboard</h2>
        <ul class="sidebar-links">
            <li><a href="employeeschedule.php">Employee Schedule</a></li>
            <li><a href="supervisorleave.php">Leave Requests</a></li>
            <li><a href="timesheets.php">Timesheet Management</a></li>
            <li><a href="productreq.php">Request Product</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="splogout.php" class="logout-btn">Logout</a>
    </div>

<div class="container">
    <div class="profile-header">
        <h1>Add Product Request</h1>
    </div>
    <style> 
    
    /* Form styling */
    form {
        display: grid;
        gap: 10px;
    }
        </style>


    
    <form method="POST">
        <label for="productRequestId">Product Request ID:</label>
        <input type="text" name="productRequestId" required>
        
        <label for="productQuantity">Product Quantity:</label>
        <input type="number" name="productQuantity" required>
        
        <label for="productValue">Product Value:</label>
        <input type="number" name="productValue" step="0.01" required>
        
        <label for="productType">Product Type:</label>
        <input type="text" name="productType" required>

        <button type="submit" name="addProductRequest">Add Product Request</button>
    </form>

    <!-- Display success or error messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <script>
        // JavaScript for form validation
        document.querySelector('form').onsubmit = function(event) {
            const productRequestId = document.querySelector('[name="productRequestId"]').value;
            const productQuantity = document.querySelector('[name="productQuantity"]').value;
            const productValue = document.querySelector('[name="productValue"]').value;
            const productType = document.querySelector('[name="productType"]').value;

            // Ensure that required fields are not empty
            if (!productRequestId || !productQuantity || !productValue || !productType) {
                alert('Please fill out all required fields.');
                event.preventDefault();
            }
        };
    </script>
</div>

</body>
</html>
