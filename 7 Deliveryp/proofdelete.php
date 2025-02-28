<?php
include 'config.php';  // Include the database configuration file

// Check if an ID is passed in the URL
if (isset($_GET['id'])) {
    $packageID = $_GET['id'];

    // Prepare the SQL query to delete the record
    $sql = "DELETE FROM proof_deliveries WHERE Package_ID = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter to the SQL statement
        $stmt->bind_param("i", $packageID);

        
        if ($stmt->execute()) {
            
            header("Location:proofdelivery.php ?success=Record deleted successfully");
            exit();
        } else {
           
            echo "Error deleting record: " . $stmt->error;
        }

        
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "No ID specified to delete.";
}

$conn->close();
?>
