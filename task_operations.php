<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all tasks for the logged-in user
function getTasks($status = null) {
    global $conn;
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM tasks WHERE user_id=?";
    
    if ($status) {
        $sql .= " AND status=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $status);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    }

    $stmt->execute();
    return $stmt->get_result();
}

// Add new task
if (isset($_POST['add_task'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO tasks1 (title, description, category, due_date, status, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $title, $description, $category, $due_date, $status, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error adding task.";
    }
}
?>
