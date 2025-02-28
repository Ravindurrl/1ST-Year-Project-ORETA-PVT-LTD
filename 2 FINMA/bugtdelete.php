<?php
include 'config.php'; 

if (isset($_GET['id'])) {
    $budget_id = $_GET['id'];

    // Delete query
    $sql = "DELETE FROM budget WHERE Budget_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $budget_id);

    if ($stmt->execute()) {
        echo "Budget deleted successfully!";
        header("Location: bugtview.php"); 
        exit();
    } else {
        echo "Error deleting budget: " . $stmt->error;
    }
} else {
    echo "No budget ID provided!";
}
?>
