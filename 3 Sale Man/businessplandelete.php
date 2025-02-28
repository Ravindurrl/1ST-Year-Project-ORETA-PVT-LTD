<?php
include 'config.php';

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $businessPlanID = $_GET['id'];

    // Prepare the DELETE SQL query
    $sql = "DELETE FROM businessplan WHERE BusinessPlanID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Error preparing the SQL statement
        $error = "Error preparing statement: " . $conn->error;
    } else {
        // Bind parameters and execute the query
        $stmt->bind_param("i", $businessPlanID);
        
        if ($stmt->execute()) {
            // Success
            $success = "Business plan deleted successfully!";
            header("Location: generatebusinessplan.php");  // Redirect to the business plan list page
            exit();
        } else {
            // Error during execution
            $error = "Error deleting business plan: " . $stmt->error;
        }
        
        // Close the statement
        $stmt->close();
    }
} else {
    // Error if ID is not provided
    $error = "Business Plan ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete Business Plan</title>
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>
<div class="container">
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
        <h1>Delete Business Plan</h1>

        <!-- Success/Error Messages -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Confirmation Message -->
        <?php if (empty($error)): ?>
            <p>Are you sure you want to delete this business plan?</p>
            <a href="generatebusinessplan.php">Cancel</a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
