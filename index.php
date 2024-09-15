<?php
// Include the database connection
include 'includes/db.php';

// Initialize variables
$taskToUpdate = '';
$updateId = null;

// Fetch all tasks from the database using the API endpoint
$tasks = [];
$response = file_get_contents("http://localhost/To-Do-List/api/get_tasks.php");
if ($response) {
    $tasks = json_decode($response, true);
}

// Handle adding a new task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
    if (isset($_POST['update_id']) && !empty($_POST['update_id'])) {
        // Update task via API endpoint
        $id = $_POST['update_id'];
        $task = $_POST['task'];
        $data = json_encode(['id' => $id, 'task' => $task]);

        $ch = curl_init("http://localhost/To-Do-List/api/update_task.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        curl_close($ch);

        // Reload the page to reflect changes
        header("Location: index.php");
        exit();
    } else {
        // Add new task via API endpoint
        $task = $_POST['task'];
        $data = json_encode(['task' => $task]);

        $ch = curl_init("http://localhost/To-Do-List/api/add_task.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        curl_close($ch);

        // Reload the page to reflect changes
        header("Location: index.php");
        exit();
    }
}

// Handle deleting a task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    // Delete task via API endpoint
    $id = $_POST['delete_id'];
    $data = json_encode(['id' => $id]);

    $ch = curl_init("http://localhost/To-Do-List/api/delete_task.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    // Reload the page to reflect changes
    header("Location: index.php");
    exit();
}

// Check if an update is needed
if (isset($_GET['edit'])) {
    $updateId = intval($_GET['edit']);
    $taskToUpdate = '';
    foreach ($tasks as $task) {
        if ($task['id'] == $updateId) {
            $taskToUpdate = $task['task'];
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Muchiri's To Do List</h2>

    <!-- Add or Update task form -->
    <form action="index.php" method="POST" class="mb-3">
        <div class="input-group">
            <input type="hidden" name="update_id" value="<?php echo htmlspecialchars($updateId); ?>">
            <input type="text" name="task" class="form-control" placeholder="Enter your task" value="<?php echo htmlspecialchars($taskToUpdate); ?>" required>
            <button type="submit" class="btn btn-primary"><?php echo $updateId ? 'Update Task' : 'Add Task'; ?></button>
        </div>
    </form>

    <!-- Display Tasks -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Task</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo htmlspecialchars($task['task']); ?></td>
                    <td>
                        <!-- Edit Task Button -->
                        <form action="index.php" method="GET" style="display:inline-block;">
                            <input type="hidden" name="edit" value="<?php echo $task['id']; ?>">
                            <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                        </form>

                        <!-- Delete Task Form -->
                        <form action="index.php" method="POST" style="display:inline-block;">
                            <input type="hidden" name="delete_id" value="<?php echo $task['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
