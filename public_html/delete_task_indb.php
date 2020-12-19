<?php
    require_once 'data_layer.php';
    
    if (isset($_GET['id'])) {
        $taskid = htmlspecialchars($_GET['id']);
        delete_task_data($taskid);
        header("location: Tasks.php");
    }
?>