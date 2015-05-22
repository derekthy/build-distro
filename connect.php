<?php
$connection = mysql_connect('mysql.0hosting.org', 'user_name', 'password');
if (!$connection){
    die("Database Connection Failed" . mysql_error());
}
$select_db = mysql_select_db('db_name');
if (!$select_db){
    die("Database Selection Failed" . mysql_error());
}