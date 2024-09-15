<?php
include '../includes/db.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'] ?? '';

    if (!empty($id)) {
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["message" => "Task deleted successfully"]);
        } else {
            echo json_encode(["message" => "Failed to delete task"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["message" => "ID is required"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}

$conn->close();

