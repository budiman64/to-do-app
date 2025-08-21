<?php
// Include the database connection file
require 'db.php';

// Set the content type to JSON for all responses
header('Content-Type: application/json');

// Get the request method (GET, POST, etc.)
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Handle GET request: Fetch all tasks
    $sql = "SELECT id, task FROM tasks ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $tasks = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
    }
    echo json_encode($tasks);

} elseif ($method === 'POST') {
    // Handle POST request: Add or delete a task
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';

    if ($action === 'add') {
        // Add a new task
        $task = $data['task'] ?? '';
        if (!empty($task)) {
            // Prepare statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO tasks (task) VALUES (?)");
            $stmt->bind_param("s", $task);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'id' => $stmt->insert_id]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add task']);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Task cannot be empty']);
        }

    } elseif ($action === 'delete') {
        // Delete a task
        $id = $data['id'] ?? 0;
        if ($id > 0) {
            // Prepare statement to prevent SQL injection
            $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete task']);
            }
            $stmt->close();
        } else {
             echo json_encode(['success' => false, 'message' => 'Invalid task ID']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
}

// Close the database connection
$conn->close();
?>
