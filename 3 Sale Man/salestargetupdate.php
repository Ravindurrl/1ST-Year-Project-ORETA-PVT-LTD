<?php
include 'config.php';

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $salesTargetID = $_GET['id'];

    // Fetch existing sales target data
    $sql = "SELECT * FROM sales_target WHERE SalesTargetID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $salesTargetID);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Fetch the current sales target data
            $row = $result->fetch_assoc();
            $nameOfSalesTarget = $row['NameofSalesTarget'];
            $startDate = $row['StartDate'];
            $endDate = $row['EndDate'];
            $description = $row['Description'];
        } else {
            $error = "Sales target not found.";
        }
    } else {
        $error = "Error fetching sales target: " . $stmt->error;
    }

    // Check if the form is submitted to update the sales target
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nameOfSalesTarget = $_POST['nameOfSalesTarget'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $description = $_POST['description'];

        // SQL query to update the sales target data
        $sql = "UPDATE sales_target SET NameofSalesTarget = ?, StartDate = ?, EndDate = ?, Description = ? WHERE SalesTargetID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nameOfSalesTarget, $startDate, $endDate, $description, $salesTargetID);

        if ($stmt->execute()) {
            $success = "Sales target updated successfully!";
            header("Location: viewsalestarget.php"); // Redirect to the Sales Target view page
            exit();
        } else {
            $error = "Error updating sales target: " . $stmt->error;
        }
    }
} else {
    $error = "Sales Target ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Sales Target</title>
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>
<div class="container">
    <div class="main-content">
        <h1>Update Sales Target</h1>
        <div class="container">
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
        <!-- Sales Target Update Form -->
        <?php if (isset($nameOfSalesTarget)): ?>
            <form method="POST">
                <label for="nameOfSalesTarget">Name of Sales Target</label>
                <input type="text" name="nameOfSalesTarget" value="<?php echo $nameOfSalesTarget; ?>" required><br>

                <label for="startDate">Start Date</label>
                <input type="date" name="startDate" value="<?php echo $startDate; ?>" required><br>

                <label for="endDate">End Date</label>
                <input type="date" name="endDate" value="<?php echo $endDate; ?>" required><br>

                <label for="description">Description</label>
                <textarea name="description" required><?php echo $description; ?></textarea><br>

                <button type="submit">Update Sales Target</button>
            </form>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
