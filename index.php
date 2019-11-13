<?php
//Checking submission
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $error = array();

    if(empty($_POST['firstName'])){
        $error[] = 'you forget to enter you first name';
    }else{
        $fn = trim($_POST['firstName']);
    }

    if(empty($_POST['lastName'])){
        $error[] = 'you forget to enter you last name';
    }else{
        $ln = trim($_POST['lastName']);
    }

    if(empty($_POST['age'])){
        $error[] = 'you forget to enter you age';
    }else{
        $ag = trim($_POST['age']);
    }

    if(empty($error)){
        require('include/mysql_connect.php');

        $q = "INSERT INTO employee (first_name,last_name,age) VALUES ('$fn','$ln','$ag')";
        $r = @mysqli_query ($dbc, $q); // Run the query.

        if($r){
            echo '<div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" arial-lable="close">&times;</a>
            <strong>Success!</strong> You registerd successfuly.Thank you!!!</div>';
        }else{
            echo '<h2>System error</h2>';
        }
        
    }else{
         echo '<h1>Error!</h1>
         <p class="error">The following error(s) occurred:<br />';
         foreach ($error as $msg) { // Print each error.
         echo " - $msg<br />\n";
}
        echo '<h2>Please try again.</h2>';
    }
}
?>

<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Employee Attendance</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="stylesheet" href="css/3.3.7/css/bootstrap.min.css">
        <script src="css/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="css/3.3.7/js/bootstrap.min.js"></script>
        <script>
           function check(){
            var chkd = document.getElementById('attend').checked;
            if(chkd == 1){
                document.getElementById('demoMsg').className="alert alert-success alert-dismissible";
                document.getElementById('demoMsg').innerHTML="They All Attened!!!";
            }else{
                document.getElementById('demoMsg').className="alert alert-danger alert-dismissible";
                document.getElementById('demoMsg').innerHTML="Some Employee Does not Attend!!!";
            }
        }
        </script>
    </head>

    <body style="background-color:">
        <div class="container">
        <h3>Employee Attendance Project</h3>
            <ul class="nav nav-tabs">
                <li><a href="#register" data-toggle="tab">Register</a></li>
                <li><a href="#attendance" data-toggle="tab">Attendance</a></li>
            </ul>
            <div class="tab-content">
                <div id="register" class="tab-pane fade in active">
                        <div class="col-sm-10">
                                <fieldset>
                                    <legend>Enter new Employee</legend>
                                    <form action="index.php" method="post">
                                        <div class="form-group">
                                            <label for="fnm">First Name:</label>
                                            <input type="text" class="form-control" name="firstName" id="fnm" >
                                        </div>
                                        <div class="form-group">
                                            <label for="lnm">Last Name:</label>
                                            <input type="text" class="form-control" name="lastName" id="lnm" >
                                        </div>
                                        <div class="form-group">
                                            <label for="age">Age:</label>
                                            <input type="number" class="form-control" name="age" id="age" >
                                        </div>
                                        <div class="form-group">
                                            <label class="radio-inline"><input type="radio" name="gender" checked>Male</label>
                                            <label class="radio-inline"><input type="radio" name="gender">Female</label>
                                            <label class="radio-inline"><input type="radio" name="gender">Other</label>
                                        </div>
                    
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </form>
                                </fieldset>
                        </div>
                </div>
                <div id="attendance" class="tab-pane fade">
                    
                    <!-- fetching results -->
                    <?php
                    echo '<h2>Attendance Room</h2>';
                    
                    

                    //Make the query
                    $q = "select first_name,last_name from employee";
                    $r = @mysqli_query($dbc,$q);

                    // if query run okay
                    if($r){
                        // table header and filter
                        echo '<input type="text" class="form-control" id="myInput" placeholder="Search.."><br/>
                        <table class="table table-bordered table-striped"><tr><th>First Name</th><th>Last Name</th>
                        <th>Check if they Attend</th></tr>';

                        // fetch and print all records:
                        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
                            echo '<tbody id="myTable"><tr><td>' . $row['first_name'] . '</td><td>' . $row['last_name'] . '</td>
                            <td><input type="checkbox" class="form-control" id="attend"></td></tr></tbody>';
                        }

                        echo '</table><button type="submit" class="btn btn-success" onclick="check()">Result</button>
                        ';
                        echo '<div class="alert alert-success alert-dismissible" id="demoMsg"><a href="#" class="close" data-dismiss="alert" arial-lable="close">&times;</a>
                        </div>';

                        // free up resource
                        mysqli_free_result($r);
                    }else{
                        echo '<p>The current employess could not be retrived. We apologize for any inconvenience.</p>';

                        // debugging the message:
                        echo 'p' . @mysqli_error($dbc) . '<br/><br />Query: ' . $q . '</p>';
                    }

                    // close the database connection
                    @mysqli_close($dbc);

                    ?>
                </div>
           </div>
        </div>

        <script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
    </body>
</html>