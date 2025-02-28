<?php
include 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the project_id from the form
    $project_id = $_POST['project_id'];

    // Delete query
    $sql = "DELETE FROM projects WHERE ProjectID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $project_id);

    if ($stmt->execute()) {
        echo "Project deleted successfully!";
        header("Location: projectview.php"); // Redirect to the project management page
        exit();
    } else {
        echo "Error deleting project: " . $stmt->error;
    }
}

// Fetch the current project data
if (isset($_GET['id'])) {
    $project_id = $_GET['id'];
    $sql = "SELECT * FROM projects WHERE ProjectID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $project_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $project = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Project</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(141, 7, 181);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: rgb(141, 7, 181);
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: rgb(141, 7, 181);
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: rgb(110, 5, 140);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Project</h1>
        <form method="POST">
            <input type="hidden" name="project_id" value="<?php echo $project['ProjectID']; ?>">
            
            <p>Are you sure you want to delete the project: <strong><?php echo htmlspecialchars($project['ProjectName']); ?></strong>?</p>
            
            <button type="submit">Yes, Delete Project</button>
        </form>
    </div>
</body>
</html>
