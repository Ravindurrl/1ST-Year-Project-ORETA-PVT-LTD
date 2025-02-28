<?php
include 'config.php'; 

$error = $success = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateDeliveryPartner'])) {
        // Get the input values
        $id = $_POST['delivery_partner_id'];
        $name = $_POST['delivery_partner_name'];
        $phone = $_POST['delivery_partner_tel'];

        // SQL query to update the delivery partner data
        $sql = "UPDATE delivery_partner 
                SET Delivery_Partner_Name = ?, Delivery_Partner_Tel = ? 
                WHERE Delivery_Partner_Id = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sss", $name, $phone, $id);

            // Execute the query
            if ($stmt->execute()) {
                
                header("Location: dlvrprtview.php"); 
                exit();
            } else {
                $error = "Error updating delivery partner: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch the delivery partner details for the given ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM delivery_partner WHERE Delivery_Partner_Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $deliveryPartner = $result->fetch_assoc();
    } else {
        $error = "Delivery partner not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <title>Update Delivery Partner</title>
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
    <div class="profile-header">
        <h1>Update Delivery Partner</h1>
    </div>

    <!-- Display Error/Success Messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Delivery Partner Update Form -->
    <?php if (isset($deliveryPartner)): ?>
        <form method="POST">
            <label for="delivery_partner_id">Partner ID:</label>
            <input type="text" name="delivery_partner_id" value="<?php echo $deliveryPartner['Delivery_Partner_Id']; ?>" readonly>
            
            <label for="delivery_partner_name">Name:</label>
            <input type="text" name="delivery_partner_name" value="<?php echo $deliveryPartner['Delivery_Partner_Name']; ?>" required>
            
            <label for="delivery_partner_tel">Phone No:</label>
            <input type="text" name="delivery_partner_tel" value="<?php echo $deliveryPartner['Delivery_Partner_Tel']; ?>" required>
            
            <button type="submit" name="updateDeliveryPartner">Update Delivery Partner</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
