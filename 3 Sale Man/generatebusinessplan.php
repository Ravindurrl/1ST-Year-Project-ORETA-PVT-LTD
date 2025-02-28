
<?php
include 'config.php';

$sql = "SELECT * FROM businessplan";  
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Business Plan Management</title>

    <link rel="stylesheet" href="Supevisoradd.css">
</head>
<body>

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

    <div class="main-content">
        <h1>Business Plans</h1>

        <!-- Success/Error Messages -->
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- Business Plan Table -->
        <table id="businessPlanTable">
            <thead>
                <tr>
                    <th>Business Plan ID</th>
                    <th>Description</th>
                    <th>Planned Start</th>
                    <th>Planned End</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic rows will be inserted here -->
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['BusinessPlanID'] . "</td>";
                        echo "<td>" . $row['Description'] . "</td>";
                        echo "<td>" . $row['PlannedStarted'] . "</td>";
                        echo "<td>" . $row['PlanEND'] . "</td>";
                        echo "<td>
                                <button onclick=\"window.location.href='businessplanupdate.php?id=" . $row['BusinessPlanID'] . "'\">Edit</button>
                                <button onclick=\"if(confirm('Are you sure you want to delete this business plan?')) window.location.href='businessplandelete.php?id=" . $row['BusinessPlanID'] . "';\">Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No business plans found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- New Button to Add Business Plan -->
        <button onclick="window.location.href='businessplanadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
            Add New Business Plan
        </button>
    </div>
</div>

</body>
</html>
