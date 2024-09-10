<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the task ID is passed
if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    // Fetch the task details
    $stmt = $conn->prepare("SELECT * FROM tasks1 WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
} else {
    echo "Task not found!";
    exit;
}

// Check if the form is submitted to update the task
if (isset($_POST['update_task'])) {
    $task_id = $_POST['task_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status']; // Ensure this comes correctly from the form

    // Validate status field
    if (!in_array($status, ['Pending', 'In Progress', 'Completed'])) {
        echo "Invalid status!";
        exit;
    }

    // Update task in the database
    $stmt = $conn->prepare("UPDATE tasks1 SET title=?, description=?, category=?, due_date=?, status=? WHERE id=? AND user_id=?");
    $stmt->bind_param("ssssiii", $title, $description, $category, $due_date, $status, $task_id, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error updating task.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Edit Task</h2>
    <form method="post" action="edit_task.php?task_id=<?php echo $task_id; ?>">
        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $task['title']; ?>" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $task['description']; ?></textarea><br><br>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?php echo $task['category']; ?>" required><br><br>

        <label for="due_date">Due Date:</label>
        <input type="date" id="due_date" name="due_date" value="<?php echo $task['due_date']; ?>" required><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="Pending" <?php if ($task['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="In Progress" <?php if ($task['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
            <option value="Completed" <?php if ($task['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
        </select><br><br>

        <button type="submit" name="update_task">Update Task</button>
    </form>
</body>
</html>
