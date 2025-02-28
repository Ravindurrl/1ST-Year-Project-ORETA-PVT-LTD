<?php
include 'config.php';  
$sql = "SELECT * FROM proof_deliveries"; 
$result = $conn->query($sql); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Package Management</title>
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
        <h1>Package Information</h1>

       
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <table id="packageTable">
            <thead>
                <tr>
                    <th>Package ID</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Delivery Partner ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['Package_ID'] . "</td>";
                        echo "<td>" . $row['Package_Description'] . "</td>";
                        echo "<td>" . $row['delstatus'] . "</td>";
                        echo "<td>" . $row['Delivery_Partner_Id'] . "</td>";
                        echo "<td>
                                <button onclick=\"window.location.href='proofupdate.php?id=" . $row['Package_ID'] . "'\">Edit</button>
                                <button onclick=\"if(confirm('Are you sure you want to delete this package?')) window.location.href='proofdelete.php?id=" . $row['Package_ID'] . "';\">Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No packages found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        
        <button onclick="window.location.href='addproof.php'" style="padding: 10px 20px; background-color: white; color: black; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;">
            Add New Package
        </button>
    </div>
</div>

</body>
</html>
