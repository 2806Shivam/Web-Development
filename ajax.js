// Update task status dynamically
function updateTaskStatus(taskId, newStatus) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "task_operations.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Reload page or update UI dynamically
            location.reload(); // Optionally, use AJAX to update UI without reloading
        }
    };
    xhr.send("task_id=" + taskId + "&status=" + newStatus);
}
