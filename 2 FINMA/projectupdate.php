<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $project_id = $_POST['project_id'];
    $project_name = $_POST['project_name'];
    $project_cost = $_POST['project_cost'];
    $project_type = $_POST['project_type'];
    $project_date = $_POST['project_date'];

    // Update query
    $sql = "UPDATE projects SET ProjectName = ?, ProjectCost = ?, ProjectType = ?, ProjectDate = ? WHERE ProjectID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Check for errors in the query preparation
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    // Bind the parameters
    $stmt->bind_param('sdssi', $project_name, $project_cost, $project_type, $project_date, $project_id);

    if ($stmt->execute()) {
        echo "Project updated successfully!";
        header("Location: projectview.php"); // Redirect to the project management page
        exit();
    } else {
        // Output the error if the query fails
        echo "Error updating project: " . $stmt->error;
    }
}

// Fetch the current project data
if (isset($_GET['id'])) {
    $project_id = $_GET['id'];
    $sql = "SELECT * FROM projects WHERE ProjectID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Check for errors in the query preparation
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    $stmt->bind_param('i', $project_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $project = $result->fetch_assoc();

    if (!$project) {
        echo "Project not found.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Project</title>
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
        <h1>Update Project</h1>
        <form method="POST">
            <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($project['ProjectID']); ?>">

            <label for="project_name">Project Name:</label>
            <input type="text" id="project_name" name="project_name" value="<?php echo htmlspecialchars($project['ProjectName']); ?>" required>

            <label for="project_cost">Project Cost:</label>
            <input type="number" id="project_cost" name="project_cost" value="<?php echo htmlspecialchars($project['ProjectCost']); ?>" step="0.01" required>

            <label for="project_type">Project Type:</label>
            <input type="text" id="project_type" name="project_type" value="<?php echo htmlspecialchars($project['ProjectType']); ?>" required>

            <label for="project_date">Project Date:</label>
            <input type="date" id="project_date" name="project_date" value="<?php echo htmlspecialchars($project['ProjectDate']); ?>" required>

            <button type="submit">Update Project</button>
        </form>
    </div>
</body>
</html>
