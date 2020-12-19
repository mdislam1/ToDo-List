<?php
    require_once "data_layer.php";
    if ($_POST) {
        if(isset($_POST['add_button'])){
            $category_name = $_POST['category_name'];
            add_category($category_name);
            header("location: category.php");
        }
    }
?>