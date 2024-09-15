<?php
include '../includes/db.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'] ?? '';
    $task = $data['task'] ?? '';

    if (!empty($id) && !empty($task)) {
        $stmt = $conn->prepare("UPDATE tasks SET task = ? WHERE id = ?");
        $stmt->bind_param("si", $task, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["message" => "Task updated successfully"]);
        } else {
            echo json_encode(["message" => "Failed to update task"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["message" => "ID and task are required"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Update Task</h2>
    
    <!-- Update task form -->
    <form action="" method="POST">
        <div class="input-group mb-3">
            <input type="text" name="task" class="form-control" value="<?php echo $task['task']; ?>" required>
            <button type="submit" class="btn btn-primary">Update Task</button>
        </div>
    </form>
</div>
</body>
</html>
