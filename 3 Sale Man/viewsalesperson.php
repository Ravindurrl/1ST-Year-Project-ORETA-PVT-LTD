<?php
include 'config.php'; 

// Fetch salesperson data from the database to display in a table
$sql = "SELECT * FROM salesperson";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salesperson Management</title>
    
    <!-- Link to external CSS for styling -->
    <link rel="stylesheet" href="Supevisoradd.css">


</head>
<body>
<div class="container">
    <!-- Sidebar Navigation -->
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
<div class="container">
    <h1>Salespersons</h1>

    <!-- Success/Error Messages -->
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Salesperson Table -->
    <table id="salespersonTable">
        <thead>
            <tr>
                <th>Salesperson ID</th>
                <th>Salesperson Name</th>
                <th>Telephone</th>
                <th>Birthday</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic rows will be inserted here -->
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['spid'] . "</td>";
                    echo "<td>" . $row['spname'] . "</td>";
                    echo "<td>" . $row['sptel'] . "</td>";
                    echo "<td>" . $row['spdob'] . "</td>";
                    echo "<td>" . $row['spaddress'] . "</td>";
                    echo "<td>
                            <button onclick=\"window.location.href='salespersonupdate.php?id=" . $row['spid'] . "'\">Edit</button>
                            <button onclick=\"if(confirm('Are you sure you want to delete this salesperson?')) window.location.href='salespersondelete.php?id=" . $row['spid'] . "';\">Delete</button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No salespersons found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- New Button to Add Salesperson -->
    <button onclick="window.location.href='salespersonadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
        Add New Salesperson
    </button>

</div>

</body>
</html>
