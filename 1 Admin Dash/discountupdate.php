<?php
include 'config.php';

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $discountID = $_GET['id'];

    // Fetch the discount details from the database
    $sql = "SELECT * FROM discounts WHERE DiscountID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $discountID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $discount = $result->fetch_assoc();
    } else {
        $error = "Discount not found.";
    }
}

// Update discount details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $discountedItemPrice = $_POST['discountedItemPrice'];
    $discountedItemType = $_POST['discountedItemType'];
    $discountStartDate = $_POST['discountStartDate'];
    $discountEndDate = $_POST['discountEndDate'];

    // Update the discount in the database
    $sql = "UPDATE discounts SET DiscountedItemPrice = ?, DiscountedItemType = ?, DiscountStartDate = ?, DiscountEndDate = ? WHERE DiscountID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dsssi", $discountedItemPrice, $discountedItemType, $discountStartDate, $discountEndDate, $discountID);
    
    if ($stmt->execute()) {
        $success = "Discount updated successfully!";
        header("Location: generateDiscount.php");
        exit();
    } else {
        $error = "Error updating discount: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Discount</title>
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
    <div class="main-content">
        <h1>Edit Discount</h1>

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
        <!-- Discount Update Form -->
        <form method="POST">
            <label for="discountedItemPrice">Discounted Item Price</label>
            <input type="number" name="discountedItemPrice" value="<?php echo $discount['DiscountedItemPrice']; ?>" step="0.01" required><br>

            <label for="discountedItemType">Discounted Item Type</label>
            <input type="text" name="discountedItemType" value="<?php echo $discount['DiscountedItemType']; ?>" required><br>

            <label for="discountStartDate">Discount Start Date</label>
            <input type="date" name="discountStartDate" value="<?php echo $discount['DiscountStartDate']; ?>" required><br>

            <label for="discountEndDate">Discount End Date</label>
            <input type="date" name="discountEndDate" value="<?php echo $discount['DiscountEndDate']; ?>" required><br>

            <button type="submit">Update Discount</button>
        </form>
    </div>
</div>

</body>
</html>
