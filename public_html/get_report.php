<?php
    require_once 'data_layer.php';
    
    if (isset($_GET['week_select'])) {
        $start_date = htmlspecialchars($_GET['week_select']);
        getReport($start_date);
        header("location: Reports.php");
    }
?>