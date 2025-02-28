<?php
include 'config.php'; 

$error = $success = "";

// Handling supplier addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addSupplier'])) {
        // Get the input values
        $id = $_POST['suppl_id'];
        $name = $_POST['suppl_name'];
        $tel = $_POST['suppl_tel'];
        $address = $_POST['suppl_address'];

        // SQL query to insert supplier data
        $sql = "INSERT INTO supplier (suppl_id, suppl_name, suppl_tel, suppl_address) 
                VALUES (?, ?, ?, ?)";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Check if preparation is successful
        if ($stmt === false) {
            $error = "Error preparing statement: " . $conn->error;
        } else {
            // Bind parameters to the prepared statement
            $stmt->bind_param("ssss", $id, $name, $tel, $address);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Supplier added successfully!";
            } else {
                $error = "Error adding supplier: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

// Fetch suppliers from the database to display in a table
$sql = "SELECT * FROM supplier";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Supevisoradd.css">
    <title>Supplier Management</title>
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
        <h1>Supplier Management</h1>
    </div>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Supplier List Table -->
    <h2>List of Suppliers</h2>
    <table>
        <thead>
            <tr>
                <th>Supplier ID</th>
                <th>Name</th>
                <th>Telephone</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['suppl_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['suppl_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['suppl_tel']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['suppl_address']) . "</td>";
                    echo "<td>
                            <button onclick=\"window.location.href='supplierupdate.php?id=" . $row['suppl_id'] . "'\">Edit</button>
                            <button onclick=\"if(confirm('Are you sure you want to delete this supplier?')) window.location.href='supplierdelete.php.php?id=" . $row['suppl_id'] . "';\">Delete</button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No suppliers found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Button styled with a link -->
    <button onclick="window.location.href='supplieradd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
        Add New Supplier
    </button>
</div>

</body>
</html>
