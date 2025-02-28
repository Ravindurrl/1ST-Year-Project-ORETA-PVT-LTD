<?php
include 'config.php'; 
$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addDiscount'])) {
        // Get the input values from the form
        $discountID = $_POST['discountID'];
        $discountedItemPrice = $_POST['discountedItemPrice'];
        $discountedItemType = $_POST['discountedItemType'];
        $discountStartDate = $_POST['discountStartDate'];  
        $discountEndDate = $_POST['discountEndDate'];      

        // SQL query to insert the discount data
        $sql = "INSERT INTO discounts (DiscountID, DiscountedItemPrice, DiscountedItemType, DiscountStartDate, DiscountEndDate) 
                VALUES (?, ?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("issss", $discountID, $discountedItemPrice, $discountedItemType, $discountStartDate, $discountEndDate);

            // Execute the query
            if ($stmt->execute()) {
                // Success
                $success = "Discount added successfully!";
                header("Location: generateDiscount.php"); 
                exit();
            } else {
                // Error
                $error = "Error adding discount: " . $stmt->error;
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
    <title>Add Discount</title>
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>
<div class="container">
    
   <!-- Sidebar Navigation -->
   <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul class="sidebar-links"> 
            <li><a href="adm.html">Dashboard</a></li>
            <li><a href="cstmngview.php">Customers</a></li>
            <li><a href="empmngview.php">Employees</a></li>
            <li><a href="Supevisorviewphp.php">Supervisors</a></li>
            <li><a href="managerview.php">Managers</a></li>
            <li><a href="suppliermngview.php">Suppliers</a></li>
            <li><a href="dlvrprtview.php">Delivery Partners</a></li>
            <li><a href="generateDiscount.php">Discounts</a></li>
        </ul>
        <a href="admlogout.php" class="logout-btn">Logout</a>
        
       
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
    }
        </style>
    <!-- Discount Add Form -->
    <div class="main-content">
        <h1>Add New Discount</h1>
        <form method="POST">
            <label for="discountID">Discount ID</label>
            <input type="number" name="discountID" placeholder="Leave empty for auto-increment" min="1"><br>

            <label for="discountedItemPrice">Discounted Item Price</label>
            <input type="number" name="discountedItemPrice" step="0.01" required><br>

            <label for="discountedItemType">Discounted Item Type</label>
            <input type="text" name="discountedItemType" required><br>

            <label for="discountStartDate">Discount Start Date</label>
            <input type="date" name="discountStartDate" required><br>

            <label for="discountEndDate">Discount End Date</label>
            <input type="date" name="discountEndDate" required><br>

            <button type="submit" name="addDiscount">Save Discount</button>
        </form>
    </div>
</div>

</body>
</html>
