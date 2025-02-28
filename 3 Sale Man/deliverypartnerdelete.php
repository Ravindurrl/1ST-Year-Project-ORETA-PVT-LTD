<?php
include 'config.php'; 
$error = $success = "";

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $assigned_deliveryid = $_GET['id'];

    // SQL query to delete the assigned delivery
    $sql = "DELETE FROM assigned_delivery WHERE assigned_deliveryid = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Check if the preparation is successful
    if ($stmt === false) {
        $error = "Error preparing statement: " . $conn->error;
    } else {
        // Bind the parameter to the prepared statement
        $stmt->bind_param("i", $assigned_deliveryid);

        // Execute the query
        if ($stmt->execute()) {
            // Success
            $success = "Assigned delivery deleted successfully!";
            header("Location: deliverypartner.php"); 
        } else {
            // Error
            $error = "Error deleting assigned delivery: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
} else {
    $error = "Assigned delivery ID not provided.";
}
?>
