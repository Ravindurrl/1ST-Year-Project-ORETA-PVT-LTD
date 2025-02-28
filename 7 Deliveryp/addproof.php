<?php
include 'config.php'; 
$error = "";
$success = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $package_id = $_POST['Package_ID'];
    $package_description = $_POST['Package_Description'];
    $delstatus = $_POST['delstatus'];
    $delivery_partner_id = $_POST['Delivery_Partner_Id'];

    // Validate inputs
    if (empty($package_id) || empty($package_description) || empty($delstatus) || empty($delivery_partner_id)) {
        $error = "All fields are required!";
    } else {
      
        $sql = "INSERT INTO proof_deliveries (Package_ID, Package_Description, delstatus, Delivery_Partner_Id) 
                VALUES ('$package_id', '$package_description', '$delstatus', '$delivery_partner_id')";
        
        if ($conn->query($sql) === TRUE) {
            $success = "New package added successfully!";
            header("Location:proofdelivery.php"); 
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Package</title>
    <link rel="stylesheet" href="Supevisoradd.css"> 
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
        <h1>Add New Package</h1>

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

        
        <form method="POST" action="addprof.php">
            <label for="Package_ID">Package ID:</label>
            <input type="number" id="Package_ID" name="Package_ID" required>

            <label for="Package_Description">Description:</label>
            <input type="text" id="Package_Description" name="Package_Description" required>

            <label for="delstatus">Delivery Status:</label>
            <input type="text" id="delstatus" name="delstatus" required>

            <label for="Delivery_Partner_Id">Delivery Partner ID:</label>
            <input type="number" id="Delivery_Partner_Id" name="Delivery_Partner_Id" required>

            <button type="submit" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
                Add Package
            </button>
        </form>
    </div>
</div>

</body>
</html>
