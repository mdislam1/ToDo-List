<?php
    
    // Fill out later 
    $server = "";
    $userName = "";
    $pass = "";
    $db = "";
    
    function get_report($start_date) {
        global $server, $userName, $pass, $db;
        $startDate = date_create(NULL, timezone_open("America/Detroit"));
      
        $startDate = date_format($startDate, "Y-m-d");
        
        $con=mysqli_connect($server, $userName, $pass, $db);
        if (mysqli_connect_errno()) {
            echo "failed to connect to MYSQL: " , mysqli_connect_errno();
        }
        
        $result = mysqli_query($con, "SELECT Tasks.date_completed, COUNT(Tasks.date_completed) AS 'amount' 
                    FROM Tasks 
                    WHERE Tasks.date_completed 
                    BETWEEN (?) AND DATE_ADD((?), INTERVAL +1 WEEK) 
                    GROUP BY date_completed;");
              
        $stmt = $result;      
        mysqli_stmt_execute($stmt);
        mysqli_close($con);

        $data=array();
        while ($row = mysqli_fetch_array($result)) {
            $temp=array();
            array_push($temp, $row['date_completed']);
            array_push($temp, $row['amount']);
            array_push($data, $temp);

        }
        mysqli_close($con);

        return $data;
    }
    
    function add_task($task_desc, $task_priority, $task_due_date, $category_id){
        global $server,$userName,$pass,$db;
    
        $con=mysqli_connect($server,$userName,$pass,$db);
        if(mysqli_connect_errno()) {
            echo "Failed to connect to MYSQL: " . mysqli_connect_errno();
            die();
        }
        /*
        This portion of the code was collected from
        https://stackoverflow.com/questions/2228430/mysqli-throws-warning-mysqli-stmt-bind-param-expects-parameter-1-to-be-mysql
        */
        if ($category_id != NULL) {
        $query = "INSERT INTO Tasks (task_description, due_date, category_id, priority_level, is_Complete)
            VALUES('$task_desc', '$task_due_date', '$category_id', '$task_priority', FALSE);";
        }
        else {
            $query = "INSERT INTO Tasks (task_description, due_date, priority_level, is_Complete)
            VALUES('$task_desc', '$task_due_date', '$task_priority', FALSE);";
        }
        $stmt = mysqli_query($con, $query);
        if ( !$stmt ){
            die('mysqli error: '.mysqli_error($con));
        }
        mysqli_close($con); 
    }

    function get_task_data() {
        global $server, $userName, $pass, $db;

        $con=mysqli_connect($server, $userName, $pass, $db);
        if (mysqli_connect_errno()) {
            echo "failed to connect to MYSQL: " , mysqli_connect_errno();
        }
        
        $result = mysqli_query($con, "SELECT DISTINCT Tasks.task_id, Tasks.task_description, Tasks.due_date, Categories.name, Tasks.priority_level, Tasks.is_Complete , Tasks.category_id, Tasks.date_completed
        FROM Tasks
        LEFT JOIN Categories ON Categories.category_id = Tasks.category_id
        ORDER BY Tasks.due_date ASC;");

        $data=array();
        while ($row = mysqli_fetch_array($result)) {
            $temp=array();
            array_push($temp, $row['task_id']);
            array_push($temp, $row['task_description']);
            array_push($temp, $row['due_date']);
            if (is_null($row['category_id']))
                array_push($temp, 'None');
            else
                array_push($temp, $row['name']);
            array_push($temp, $row['priority_level']);
            array_push($temp, $row['is_Complete']);
            array_push($temp, $row['date_completed']);
            array_push($data, $temp);

        }
        mysqli_close($con);

        return $data;
    }
    
    function delete_task_data($task_id) {
    global $server, $userName, $pass, $db;
    
    $con=mysqli_connect($server, $userName, $pass, $db);
    if (mysqli_connect_errno()) {
        echo "failed to connect to MYSQL: " , mysqli_connect_errno();
    }
    $stmt = mysqli_prepare($con, "DELETE FROM Tasks WHERE task_id=?");
    mysqli_stmt_bind_param($stmt, "i", $task_id);
    mysqli_stmt_execute($stmt);
    mysqli_close($con);
    }
    
    function mark_task_as_complete($task_id) {
    global $server, $userName, $pass, $db;
    
    $con=mysqli_connect($server, $userName, $pass, $db);
    if (mysqli_connect_errno()) {
        echo "failed to connect to MYSQL: " , mysqli_connect_errno();
    }
    
    
    /*mark as complete*/
    $stmt = mysqli_prepare($con, "CALL markAsComplete(?)");
    mysqli_stmt_bind_param($stmt, "i", $task_id);
    mysqli_stmt_execute($stmt);
    
    mysqli_close($con);
    }
    
    function add_category($category_name){
        global $server,$userName,$pass,$db;
    
        $con=mysqli_connect($server,$userName,$pass,$db);
        if(mysqli_connect_errno()) {
            echo "Failed to connect to MYSQL: " . mysqli_connect_errno();
            die();
        }
        /*
        This portion of the code was collected from
        https://stackoverflow.com/questions/2228430/mysqli-throws-warning-mysqli-stmt-bind-param-expects-parameter-1-to-be-mysql
        */
        $query = "INSERT INTO Categories (name) VALUES(?);";
        $stmt = mysqli_prepare($con, $query);
        if ( !$stmt ){
            die('mysqli error: '.mysqli_error($con));
        }
        mysqli_stmt_bind_param($stmt,'s',$category_name);
        if ( !mysqli_execute($stmt) ) {
            die( 'stmt error: '.mysqli_stmt_error($stmt) );
        }
        mysqli_close($con); 
    }
    
    function show_category(){
        global $server,$userName,$pass,$db;
    
        $con=mysqli_connect($server,$userName,$pass,$db);
        if(mysqli_connect_errno()) {
            echo "Failed to connect to MYSQL: " . mysqli_connect_errno();
            die();
        }
        
        $result = mysqli_query($con,"SELECT * FROM Categories;");
        $data=array();
        while($row = mysqli_fetch_array($result)) {
            $temp=array();
            array_push($temp, $row['name']);
            array_push($temp, $row['category_id']);
            array_push($data, $temp);
        }
        mysqli_close($con); 
        return $data;
    }
    
    function delete_category_data($category_id) {
        global $server, $userName, $pass, $db;
        
        $con=mysqli_connect($server, $userName, $pass, $db);
        if (mysqli_connect_errno()) {
            echo "failed to connect to MYSQL: " , mysqli_connect_errno();
        }
        $stmt = mysqli_prepare($con, "CALL removeCategory(?)");
        mysqli_stmt_bind_param($stmt, "i", $category_id);
        mysqli_stmt_execute($stmt);
        mysqli_close($con);
    }
    
    function view_between_dates($numOfDays){
        global $server, $userName, $pass, $db;
        $startDate = date_create(NULL, timezone_open("America/Detroit"));
        $endDate = date_create(NULL, timezone_open("America/Detroit"));
        $endDate = date_add($endDate, date_interval_create_from_date_string("$numOfDays days"));
        
        $startDate = date_format($startDate, "Y-m-d");
        $endDate = date_format($endDate, "Y-m-d");
        
        $con=mysqli_connect($server, $userName, $pass, $db);
        if (mysqli_connect_errno()) {
            echo "failed to connect to MYSQL: " , mysqli_connect_errno();
        }
        
        $result = mysqli_query($con, "SELECT `Tasks`.`task_id`, `Tasks`.`task_description`,`Tasks`.`due_date`,
        	`Tasks`.`category_id`, `Categories`.`name`, `Tasks`.`priority_level`, `Tasks`.`is_Complete`, `Tasks`.`date_completed`
            FROM `Tasks`
            LEFT JOIN Categories ON Categories.category_id = Tasks.category_id
            WHERE `Tasks`.`due_date` BETWEEN '$startDate' AND '$endDate'");
        $data = array();
         while ($row = mysqli_fetch_array($result)) {
            $temp=array();
            array_push($temp, $row['task_id']);
            array_push($temp, $row['task_description']);
            array_push($temp, $row['due_date']);
            if (is_null($row['category_id']))
                array_push($temp, 'None');
            else
                array_push($temp, $row['name']);
            array_push($temp, $row['priority_level']);
            array_push($temp, $row['is_Complete']);
            array_push($temp, $row['date_completed']);
            array_push($data, $temp);

        }
        mysqli_close($con);
        return $data;

    }
    
    
?>