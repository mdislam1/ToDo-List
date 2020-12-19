<?php
    require_once "data_layer.php";
    function display_table($week_select) {
        $result = get_report($week_select);
        foreach ($result as $row) {
            echo "<tr>";
            //date
            echo "<td>" , $row[0] , "</td>";
            //tasks on date
            echo "<td>" , $row[1] , "</td>";
           
        }
    }
    ?>
    
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.css">
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<head>
    <meta charset="utf-8">
    <title>Team 10 Project: Tasks</title>
</head>


<div class="header">
  <a href="/index.html">
    <h3 class="ui left floated huge red header">
        Team 10 Project
    </h3>
  </a>
</div>

<!--jquery should be above semantic because of dependencies-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
   
<nav>
  <!--whatever pages we want-->
  <div class="ui attached stackable menu">
      <!--how to make this fully left l-->
      <div class="ui container">
          <a class="item" href="index.html">
              <i class="home icon" id="homeButton"></i> Home
          </a>
          <a class="item" href="Tasks.php">
              <i class="tasks icon" id="tasksButton"></i> Tasks
          </a>
          <a class="item" href="Reports.php">
              <i class="envelope open icon" id="reportsButton"></i> Reports
          </a>
          <a class="item" href="category.php">
              <i class="list ul icon" id="categoryButton"></i> Category
          </a>
          <a class="item" href="aboutUs.html">
              <i class="id card icon"></i> About Us
          </a>
      </div>
  </div>

</nav>

<body>
    <div class="ui container">
        <h1>Task Table:</h1>
        <div class="form" action="get_report.php">
            <div class="field">
                <label>Week:</label>
                <input type="date" name"week_select" id="week_select">
                <input type="submit" value="Submit">
            </div>
        </div>
        <br>
        <table id="report_table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Tasks Completed</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($_GET["week_select"])){
            	    // The value of the variable name is found
            	        display_table($_GET["week_select"]);
                        
                    }
                ?>
            </tbody>
        </table>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#report_table').DataTable();
        });
    </script>
</body>