<?php
    require_once "data_layer.php";

    function show_category_fromdb(){
        $result = show_category();
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td colspan='3'>" . $row[0] . "</td>";
            echo "<td class='right aligned' colspan='1'>" , "<a class='ui red inverted button' href='delete_category_indb.php?id=" , $row[1], "'>Delete Category</a>" , "</td>";
            echo "</tr>";
        }
    }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Team 10 Project</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.css">
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
        <h1 class="ui header">Add New Category</h1>

        <form method="POST" action="add_category_indb.php">
            <div class="ui fluid action input">
                <input type="text" name="category_name"/>
                <div class="ui button">
                    <input name="add_button" type="submit" value="Add Category"/>
                </div>
            </div>
            
        </form>
        
        <table class="ui celled striped table">
            <thead>
                <tr><th colspan="3">
                    Categories
                </th>
                <th class="right aligned" colspan="1">
                    <!--Delete-->
                </th>
            </tr></thead>
            <tbody>
                <tr>
                    <?php
                        show_category_fromdb() 
                    ?>
                </tr>
            </tbody>
        </table>
    </div>
    
</body>

</html>