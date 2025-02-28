<?php
include 'config.php';  
$error = "";
$success = "";

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateProofDelivery'])) {
        // Get the input values from the form
        $package_id = $_POST['Package_ID'];
        $package_description = $_POST['Package_Description'];
        $delstatus = $_POST['delstatus'];
        $delivery_partner_id = $_POST['Delivery_Partner_Id'];

      
        $sql = "UPDATE proof_deliveries 
                SET Package_Description = ?, delstatus = ?, Delivery_Partner_Id = ? 
                WHERE Package_ID = ?";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if the preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("ssii", $package_description, $delstatus, $delivery_partner_id, $package_id);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Proof Delivery updated successfully!";
                header("Location: proofdelivery.php");
                exit();
            } else {
                $error = "Error updating Proof Delivery: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch the Proof Delivery data to pre-fill the form
if (isset($_GET['id'])) {
    $package_id = $_GET['id'];
    $sql = "SELECT * FROM proof_deliveries WHERE Package_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $package_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $package_description = $row['Package_Description'];
        $delstatus = $row['delstatus'];
        $delivery_partner_id = $row['Delivery_Partner_Id'];
    } else {
        $error = "Proof Delivery not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Proof Delivery</title>
    
    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>

<div class="container">
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <h2>Delivery Partner</h2>
        <ul class="sidebar-links">
         
            <li><a href="proofdelivery.php">📝 Proof of Delivery</a></li>
            <li><a href="assigneddelivery.php">📋 Assigned Orders</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="dlvlogout.php" class="logout-btn">Logout</a>
    </aside>
    <div class="main-content">
        <h1>Update Proof Delivery</h1>

        <!-- Success/Error Messages -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Proof Delivery Update Form -->
        <form method="POST">
            <input type="hidden" name="Package_ID" value="<?php echo $package_id; ?>">

            <label for="Package_Description">Description</label>
            <input type="text" name="Package_Description" value="<?php echo $package_description; ?>" required>

            <label for="delstatus">Delivery Status</label>
            <input type="text" name="delstatus" value="<?php echo $delstatus; ?>" required>

            <label for="Delivery_Partner_Id">Delivery Partner ID</label>
            <input type="number" name="Delivery_Partner_Id" value="<?php echo $delivery_partner_id; ?>" required>

            <button type="submit" name="updateProofDelivery" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
                Update Proof Delivery
            </button>
        </form>
    </div>
</div>

</body>
</html>
