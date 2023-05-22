<?php

//include constants File
include('../config/constants.php');
//echo"Delete page";
//check whether the id and image_name value is set or not
if (isset($_GET['id']) and isset($_GET['image_name'])) {
    //Get the value and Delete
    //echo "get the value";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //Remove the physical file is avialable
    if ($image_name != "") {
        //image is Available.so remove it
        $path = "../images/category/" . $image_name;
        //Remove the image
        $remove = unlink($path);

        //if failed to remove image then add an error message
        if ($remove == false) {
            //set the session message
            $_SESSION['remove'] = "<div class='error'>Failed to remove category image.</div>";
            //redirect to manage category page
            header('location:' . SITEURL . 'admin/manage-category.php');
            //stop the process
            die();
        }
    }


    //Delete data from database
    //SQL Query to Delete from Database
    $sql = "DELETE FROM tbl_category WHERE id=$id";

    //Execute the Query
    $res = mysqli_query($conn, $sql);

    //check whether the data is deleted from the database or not
    if ($res == true) {
        //set success message and redirect
        $_SESSION['delete'] = "<div class='success'>Deleted successfully.</div>";
        //Redirect to manage category
        header('location:' . SITEURL . 'admin/manage-category.php');
    } else {
        //set success message and redirect
        $_SESSION['delete'] = "<div class='error'>Failed to delete category.</div>";
        //Redirect to manage category
        header('location:' . SITEURL . 'admin/manage-category.php');
    }

} else {
    //Redirect to manage category page
    header('location:' . SITEURL . 'admin/manage-category.php');
}
?>