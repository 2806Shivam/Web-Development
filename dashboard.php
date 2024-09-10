<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'db.php';
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM tasks1 WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Dashboard</title>
</head>
<body>
<div class="container">
    <a href="logout.php">Logout</a>

    <h2>Your Tasks</h2><hr><br>
    <form action="add_task.php" method="POST">
        <button type="submit">Add Task</button>
    </form>
    <hr><br>
    <h2>Your Current Tasks</h2>
    <?php while ($task = mysqli_fetch_assoc($result)) : ?>
        <div class="task">
            <h4><?php echo $task['title']; ?></h4>
            <p><?php echo $task['category']; ?> - <?php echo $task['status']; ?></p>
            <a href="edit_task.php?id=<?php echo $task['id']; ?>">Edit</a>
            <a href="delete_task.php?id=<?php echo $task['id']; ?>">Delete</a>
        </div>
    <?php endwhile; ?>
</div>
</body>
</html>
