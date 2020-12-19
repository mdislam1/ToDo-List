<?php
    require_once "data_layer.php";
    if ($_POST) {
        if(isset($_POST['add_button'])){
            $task_desc = $_POST['task_description'];
            $due_date = $_POST['due_date'];
            $priority_level = $_POST['priority_level'];
            $category = $_POST['category'];
            if ($category == "")
                $category = null;
            add_task($task_desc, $priority_level, $due_date, $category);
            header("location: Tasks.php");
        }
    }   
?>