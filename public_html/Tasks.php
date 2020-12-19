<?php
    require_once "data_layer.php";
    function display_table($filt) {
        $filt = (int)$filt;
        if ($filt < 0){
            $result = get_task_data();
        } else {
            $result = view_between_dates($filt);
        }
        foreach ($result as $row) {
            echo "<tr>";
            //task description
            echo "<td>" , $row[1] , "</td>";
            //due date
            echo "<td>" , $row[2] , "</td>";
            //category
            //may have to implement a check to say none
            echo "<td>" , $row[3] , "</td>";
            //Priority level
            echo "<td>" , $row[4] , "</td>";
            //is completed
            //may make a check box
            if ($row[5] == 0)
                echo "<td>" , "<a class='ui green inverted button' href='mark_as_complete.php?id=" , $row[0], "'>Mark as Complete</a>" , "</td>";
            else if ($row[5] == 1)
                echo "<td>Completed on:</br>", $row[6] , "</td>";
            echo "<td>" , "<a class='ui red inverted button' href='delete_task_indb.php?id=" , $row[0], "'>Delete Task</a>" , "</td>";                
            echo "</tr>";
        }
    }
    
    function show_category_fromdb(){
        $result = show_category();
        foreach ($result as $row) {
            echo "<option name='category' value=$row[1]>" . $row[0] . "</option>";
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
    <form action="changeRange.php">
        <label for="newFilt">View items that are due: </label>
        <select name="newFilt" id="newFilt">
            <option value=-1>Any time </option>
            <option value=0>Today</option>
            <option value=1>Tomorrow</option>
            <option value=7>This week</option>
        </select>
        <input type="submit" value="Submit">
    </form>
    <br>
    <table id="table_id" class="display" style="width:100%">
      <thead>
        <tr>
          <!--<i class="sort icon"></i>-->
          <th>Task Description</th>
          <th>
            Due Date
            </th>
          <th>
            Category
          </th>
          <th>
            Priority Level
          </th>
          <th>Is Complete?</th>
          <th><!--Delete--></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if(isset($_GET["dueFilt"])){
	    // The value of the variable name is found
	        display_table($_GET["dueFilt"]);
        } else {
            display_table("-1");
        }
        ?>
      </tbody>
      
    </table>
    
    
    <div class="ui modal">
    <i class="close icon"></i>
    <div class="content">
        <h2 class="ui header">Add a Task:</h2>
            <form class="ui form" method="POST" action="add_task_indb.php">
              <div class="field">
                <label>Task Description</label>
                <textarea name="task_description" id="description" minlength="1"></textarea>
              </div>
              <div class="field">
                <label>Due Date:</label>
                <input type="date" name="due_date" id="date">
              </div>
                <div class="inline fields">
                    <label for="priority">Priority Level:</label>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="priority_level" tabindex="0" class="hidden" value=1>
                        <label>1 (highest priority)</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="priority_level" tabindex="0" class="hidden" value=2>
                        <label>2</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="priority_level" tabindex="0" class="hidden" value=3>
                        <label>3</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="priority_level" tabindex="0" class="hidden" value=4>
                        <label>4</label>
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <label>Category</label>
                    <select name="category">
                        <option value="">
                            <option name='category' value="">None</option>
                                <?php
                                    show_category_fromdb();
                                ?>
                        </option>
                    </select>
                  </div>
                    <input class="ui blue button" name="add_button" type="submit" value="Add Task"/>
                </form>
               </div>
            </div>
      
      <button class="ui blue button" onclick="openTaskModal()">New Task</button>

    </div>
   

<script>
    function openTaskModal() {
        $('.ui.modal').modal('show');
    }
    
    $('.ui.radio.checkbox').checkbox();
    
</script>

<script>
    $(document).ready( function () {
    $('#table_id').DataTable(
        );
    
    } );
    $('#table_id').DataTable({
       "order": [[1, "asc"]]
    });
</script>
</body>

</html>