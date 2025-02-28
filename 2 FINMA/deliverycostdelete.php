<?php
include 'config.php';

// Check if delivery_id is passed in the URL
if (isset($_GET['delivery_id'])) {
    $delivery_id = $_GET['delivery_id'];

    // SQL query to delete the record
    $sql = "DELETE FROM deliveryexp WHERE delivery_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $delivery_id);

    if ($stmt->execute()) {
        echo "Delivery record deleted successfully!";
        header("Location: deliverycostview.php"); // Redirect to the view page
        exit();
    } else {
        echo "Error deleting delivery record: " . $stmt->error;
    }
} else {
    echo "No delivery ID provided!";
}
?>
