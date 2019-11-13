<?php 
 define('db_user', 'root');
 define('db_password', '123456');
 define('db_host', 'localhost');
 define('db_name','Attendance');

 $dbc = @mysqli_connect(db_host,db_user,db_password,db_name) or die ('Could not connect to Database' . mysqli_connect_error());
 mysqli_set_charset($dbc, 'utf8');
?>