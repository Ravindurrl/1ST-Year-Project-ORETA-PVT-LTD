<?php
include 'config.php';

if (isset($_GET['id'])) {
    $package_id = $_GET['id'];

    $sql = "DELETE FROM proof_deliveries WHERE Package_ID = '$package_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Proof delivery deleted successfully!";
        header("Location: proofdelivery.php"); 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "No Package_ID provided!";
    exit;
}
?>
