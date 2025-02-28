<?php
include 'config.php'; 

$error = $success = "";

// Check if an ID is provided for deletion
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL delete query
    $sql = "DELETE FROM delivery_partner WHERE Delivery_Partner_Id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $error = "Error preparing statement: " . $conn->error;
    } else {
        // Bind parameters and execute the query
        $stmt->bind_param("s", $id);

        if ($stmt->execute()) {
            // Redirect after successful deletion
            $success = "Delivery partner deleted successfully!";
            header("Location: dlvrprtview.php");
            exit();
        } else {
            $error = "Error deleting delivery partner: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
} else {
    $error = "No delivery partner ID provided.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <title>Delete Delivery Partner</title>
</head>
<body>
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
<div class="container">
    <h1>Delete Delivery Partner</h1>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
</div>
</body>
</html>
