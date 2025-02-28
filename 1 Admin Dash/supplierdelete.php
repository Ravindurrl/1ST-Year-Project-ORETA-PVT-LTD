<?php
include 'config.php'; 

if (isset($_GET['id'])) {
    $supplierId = $_GET['id'];

    // Prepare the DELETE SQL query
    $sql = "DELETE FROM supplier WHERE suppl_id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // If there was an error 

        
        die("Error preparing statement: " . $conn->error);
    } else {
        // Bind the parameter
        $stmt->bind_param("s", $supplierId);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect with success
            header("Location: suppliermngview.php?success=Supplier deleted successfully");
        } else {
            
            header("Location: suppliermngview.php?error=Error deleting supplier: " . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    }
} else {

    header("Location: suppliermngview.php?error=Invalid supplier ID");
}


$conn->close();
?>
