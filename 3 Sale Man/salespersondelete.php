<?php
include 'config.php'; 

// Check if an ID is passed and delete the salesperson record
if (isset($_GET['id'])) {
    $spid = $_GET['id'];

    // SQL query to delete the salesperson
    $sql = "DELETE FROM salesperson WHERE spid = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Check if the preparation is successful
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    } else {
        // Bind parameter and execute the query
        $stmt->bind_param("s", $spid);
        
        if ($stmt->execute()) {
            header("Location: viewsalesperson.php"); // Redirect to salesperson view page
            exit();
        } else {
            echo "Error deleting salesperson: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
} else {
    echo "No salesperson ID provided!";
}
?>
