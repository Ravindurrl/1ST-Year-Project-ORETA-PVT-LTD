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
        <h2>Supplier </h2>
        <ul class="sidebar-links">
        <li><a href="productreq.php">📝 Product Request</a></li>
            
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
                               <select name='action_" . $row['product_request_id'] . "'>
                                    <option value=''>Select Action</option>
                                    <option value='accept'>Accept</option>
                                    <option value='decline'>Decline</option>
                                </select>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No product requests found</td></tr>";
                }
                ?>
            </tbody>
        </table>

       
    </div>
</div>

</body>
</html>
