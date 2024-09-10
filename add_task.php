<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $user_id = $_SESSION['user_id'];

    // Insert the task into the database
    $sql = "INSERT INTO tasks1 (title, description, category, due_date, status, user_id) 
            VALUES ('$title', '$description', '$category', '$due_date', '$status', '$user_id')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to dashboard after successful insertion
        header('Location: dashboard.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add a New Task</h2>
    <form method="POST" action="add_tasks.php">
        <label for="title">Task Title:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Task Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="Work">Work</option>
            <option value="Personal">Personal</option>
        </select><br><br>

        <label for="due_date">Due Date:</label>
        <input type="date" id="due_date" name="due_date" required><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="Pending">Pending</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select><br><br>

        <button type="submit">Add Task</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
