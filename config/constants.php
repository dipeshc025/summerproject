<?php

//Start session
session_start();

//create constant to store non repeating values
define('SITEURL','http://localhost/summerproject/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'food-order'); 

 
 $conn = mysqli_connect('localhost','root','') or die(mysqli_error()); //Database Connection
 $db_select = mysqli_select_db($conn,'food-order') or die(mysqli_error());  //Selecting Database


?>