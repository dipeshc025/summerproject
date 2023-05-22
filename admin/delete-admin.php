<?php

//Include Constant.php file here
include('../config/constants.php');

//1. Get the ID of Admin to be deleted
$id = $_GET['id'];

//2. Create SQL Query to delete Admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

//Execute the Query 
$res = mysqli_query($conn, $sql);

//check whether the query executed successfully or not
//3. redirect to manage Admin page with message (success/error)
if ($res == true) {
    //Query executed successfully and Admin  Deleted
    //echo "Admin Deleted";
    //Create Session variable to display message
    $_SESSION['delete'] = "<div class='success'>Admin deleteSuccessfully.</div>";
    //Redirect to manage Admin page
    header('location:' . SITEURL . 'admin/manage-admin.php');
} else {
    //Failed to Deleted Admin
    // echo "Failed to Deleted Admin";
    $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again Later.</div>";
    //Redirect to manage Admin page
    header('location:' . SITEURL . 'admin/manage-admin.php');
}



?>