<?php
//Authorization -Access control
//check whether the user is Logged in or Not
if (!isset($_SESSION['user'])) //if user session is not set
{
  //user is not logged in 
  //Redirect to login page with message
  $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin panel.</div>'";
  //Redirect to login page
  header('location:' . SITEURL . 'admin/login.php');
}
?>