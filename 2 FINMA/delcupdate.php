<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $delivery_id = $_POST['delivery_id'];
    $delivery_name = $_POST['delivery_name'];
    $delivery_cost = $_POST['delivery_cost'];
    $delivery_date = $_POST['delivery_date'];

    // Update query with correct field names
    $sql = "UPDATE deliveyexp SET delivery_name = ?, delivery_cost = ?, delivery_date = ? WHERE delivery_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Check for errors in the query preparation
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    // Bind the parameters
    $stmt->bind_param('sdsi', $delivery_name, $delivery_cost, $delivery_date, $delivery_id);

    if ($stmt->execute()) {
        echo "Delivery cost updated successfully!";
        header("Location: deliverycostview.php"); // Redirect to the delivery cost view page
        exit();
    } else {
        // Output the error if the query fails
        echo "Error updating delivery cost: " . $stmt->error;
    }
}

// Check if the delivery_id is passed in the URL
if (isset($_GET['delivery_id'])) {
    $delivery_id = $_GET['delivery_id'];
    $sql = "SELECT * FROM deliveyexp WHERE delivery_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Check for errors in the query preparation
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    $stmt->bind_param('i', $delivery_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $delivery = $result->fetch_assoc();

    if (!$delivery) {
        echo "Delivery cost not found.";
        exit();
    }
} else {
    echo "No delivery ID provided. Please make sure you are accessing the page with a valid delivery ID in the URL.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Delivery Cost</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(141, 7, 181);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: rgb(141, 7, 181);
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: rgb(141, 7, 181);
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: rgb(110, 5, 140);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Delivery Cost</h1>
         <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h2>Finance Manager</h2>
        <ul class="sidebar-links">
            <li><a href="finpaymnt.php">Payment Management</a></li>
            <li><a href="bugtview.php">Budget & Investment</a></li>
            <li><a href="projectview.php">Calculate Project Cost</a></li>
            <li><a href="report-generation.php">Generate Project Report</a></li>
            <li><a href="deliverycostview.php">Calculate Delivery Cost</a></li>
            <li><a href="salaryview.php">Calculate Employee Salary</a></li>
        </ul>
        <!-- Logout Button -->
        <a href="fmlogout.php" class="logout-btn">Logout</a>
    </div>
        <form method="POST">
           <!-- Hidden input for delivery_id -->
<input type="hidden" name="delivery_id" value="<?php 
    if (isset($_GET['delivery_id'])) {
        echo htmlspecialchars($_GET['delivery_id']);
    } elseif (isset($delivery) && isset($delivery['delivery_id'])) {
        echo htmlspecialchars($delivery['delivery_id']);
    } 
?>">

            <!-- Input for Delivery Name -->
            <label for="delivery_name">Delivery Name:</label>
            <input type="text" id="delivery_name" name="delivery_name" value="<?php echo isset($delivery) ? htmlspecialchars($delivery['delivery_name']) : ''; ?>" required>

            <!-- Input for Delivery Cost -->
            <label for="delivery_cost">Delivery Cost:</label>
            <input type="number" id="delivery_cost" name="delivery_cost" value="<?php echo isset($delivery) ? htmlspecialchars($delivery['delivery_cost']) : ''; ?>" step="0.01" required>

            <!-- Input for Delivery Date -->
            <label for="delivery_date">Delivery Date:</label>
            <input type="date" id="delivery_date" name="delivery_date" value="<?php echo isset($delivery) ? htmlspecialchars($delivery['delivery_date']) : ''; ?>" required>

            <!-- Submit Button -->
            <button type="submit">Update Delivery Cost</button>
        </form>
    </div>
</body>
</html>
