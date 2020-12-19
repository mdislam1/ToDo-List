<?php
    require_once 'data_layer.php';
    
    if (isset($_GET['id'])) {
        $categoryid = htmlspecialchars($_GET['id']);
        delete_category_data($categoryid);
        header("location: category.php");
    }
?>