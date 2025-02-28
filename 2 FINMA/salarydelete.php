<?php
include 'config.php';

if (isset($_GET['id'])) {
    $salaryid = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM salary WHERE salaryid = ?");
    $stmt->bind_param("i", $salaryid);

    if ($stmt->execute()) {
        echo "Salary deleted successfully.";
        header("Location: salaryview.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
