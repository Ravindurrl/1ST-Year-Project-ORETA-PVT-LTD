<?php
include 'config.php'; 
if (isset($_GET['id'])) {
    $supervisorId = $_GET['id'];

    // Prepare the DELETE SQL query
    $sql = "DELETE FROM supervisor WHERE sup_id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // If there was an error preparing the statement
        die("Error preparing statement: " . $conn->error);
    } else {
        // Bind the parameter
        $stmt->bind_param("i", $supervisorId);

        // Execute the statement
        if ($stmt->execute()) {
            
            header("Location: Supevisoradd.php?success=Supervisor deleted successfully");
        } else {
        
            header("Location: Supevisoradd.php?error=Error deleting supervisor: " . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    }
} else {
    
    header("Location: Supevisoradd.php?error=Invalid supervisor ID");
}

// Close the database connection
$conn->close();
?>
