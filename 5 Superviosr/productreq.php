<?php
include 'config.php';  
$sql = "SELECT * FROM ProductRequests"; 
$result = $conn->query($sql); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Requests</title>
    <link rel="stylesheet" href="Supevisoradd.css"> 
</head>
<body>

<div class="container">
    
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Supervisor Dashboard</h2>
        <ul class="sidebar-links">
            <li><a href="employeeschedule.php">Employee Schedule</a></li>
            <li><a href="supervisorleave.php">Leave Requests</a></li>
            <li><a href="timesheets.php">Timesheet Management</a></li>
            <li><a href="productreq.php">Request Product</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="splogout.php" class="logout-btn">Logout</a>
    </div>
       
    <div class="main-content">
        <h1>Product Request Information</h1>

        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <table id="productRequestTable">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Product Quantity</th>
                    <th>Product Value</th>
                    <th>Product Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['product_request_id'] . "</td>";
                        echo "<td>" . $row['product_quantity'] . "</td>";
                        echo "<td>" . $row['product_value'] . "</td>";
                        echo "<td>" . $row['product_type'] . "</td>";
                        echo "<td>
                                <button onclick=\"window.location.href='productupdate.php?id=" . $row['product_request_id'] . "'\">Edit</button>
                                <button onclick=\"if(confirm('Are you sure you want to delete this request?')) window.location.href='productdelete.php?id=" . $row['product_request_id'] . "';\">Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No product requests found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <button onclick="window.location.href='productreqadd.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
            Add New Product Request
        </button>
    </div>
</div>

</body>
</html>
