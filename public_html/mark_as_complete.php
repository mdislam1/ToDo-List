<?php
    require_once 'data_layer.php';
    
    if (isset($_GET['id'])) {
        $taskid = htmlspecialchars($_GET['id']);
        mark_task_as_complete($taskid);
        header("location: Tasks.php");
    }
?>