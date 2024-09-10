<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Delete the task
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM tasks1 WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error deleting task.";
    }
}
?>
