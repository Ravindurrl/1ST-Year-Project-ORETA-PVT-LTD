<?php
include 'config.php';

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $salesTargetID = $_GET['id'];

    // Prepare the SQL query to delete the sales target
    $sql = "DELETE FROM sales_target WHERE SalesTargetID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $salesTargetID);

    if ($stmt->execute()) {
        $success = "Sales target deleted successfully!";
        header("Location: viewsalestarget.php"); // Redirect to the sales target view page
        exit();
    } else {
        $error = "Error deleting sales target: " . $stmt->error;
    }
} else {
    $error = "Sales Target ID not provided.";
}
?>
