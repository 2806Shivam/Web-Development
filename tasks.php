<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO tasks1 (user_id, title, category, due_date, status) VALUES ('$user_id', '$title', '$category', '$due_date', '$status')";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: dashboard.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
