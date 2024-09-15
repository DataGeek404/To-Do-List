<?php
include '../includes/db.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $task = $data['task'] ?? '';

    if (!empty($task)) {
        $stmt = $conn->prepare("INSERT INTO tasks (task) VALUES (?)");
        $stmt->bind_param("s", $task);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["message" => "Task added successfully"]);
        } else {
            echo json_encode(["message" => "Failed to add task"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["message" => "Task is required"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}

$conn->close();

