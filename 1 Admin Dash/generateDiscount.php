<?php
include 'config.php'; 

// Query to get all discount information
$sql = "SELECT * FROM discounts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Discount Management</title>
    <link rel="stylesheet" href="Supevisoradd.css">
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
    <div class="main-content">
        <h1>Discount Management</h1>

        <!-- Success/Error Messages -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Discount Table -->
        <table id="discountTable">
            <thead>
                <tr>
                    <th>Discount ID</th>
                    <th>Discounted Item Price</th>
                    <th>Discounted Item Type</th>
                    <th>Discount Period</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic rows will be inserted here -->
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Format the start and end dates
                        $discountStartDate = date('Y-m-d', strtotime($row['DiscountStartDate']));
                        $discountEndDate = date('Y-m-d', strtotime($row['DiscountEndDate']));
                        echo "<tr>";
                        echo "<td>" . $row['DiscountID'] . "</td>";
                        echo "<td>" . $row['DiscountedItemPrice'] . "</td>";
                        echo "<td>" . $row['DiscountedItemType'] . "</td>";
                        echo "<td>" . $discountStartDate . " - " . $discountEndDate . "</td>"; // Discount period column
                        echo "<td>
                                <button onclick=\"window.location.href='discountupdate.php?id=" . $row['DiscountID'] . "'\">Edit</button>
                                <button onclick=\"if(confirm('Are you sure you want to delete this discount?')) window.location.href='discountdelete.php?id=" . $row['DiscountID'] . "';\">Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No discounts found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- New Button to Add Discount -->
        <button onclick="window.location.href='discountadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
            Add New Discount
        </button>
    </div>
</div>

</body>
</html>
