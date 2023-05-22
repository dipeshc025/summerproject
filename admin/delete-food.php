<?php
//Include constants page
include('../config/constants.php');


if (isset($_GET['id']) && isset($_GET['image_name'])) //Either use '&&' or 'AND' 
{
    // process to Delete

    //1. Get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //2. Remove the image if available
    //check whether the image is available or not and Delete only if available
    if($image_name!="")
    {
        //It has image and need to remove from folder
        //Get the Image path
        $path = "../images/food/".$image_name;
        
        //Remove image file from folder
        $remove = unlink($path);

        //check whether the image is remove or not
        if($remove==false)
        {
            //Failed to remove image
            $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File.</div>.";
            //Redirect ot manage food page
            header('location:'.SITEURL.'admin/manage-food.php');
            //Stop the process
            die();
        }
    }

    //3. Delete food from database
    $sql = "DELETE FROM tbl_food WHERE id=$id";

    //Execute the Query
    $res = mysqli_query($conn,$sql);

    //Check whether the Query is execute oer not set the session message respectively
    if($res==true)
    {
        //Food Delete
        $_SESSION['delete'] = "<div class='success'>Food Delete Successfully.</div>.";
        //Redirect ot manage food page
        header('location:'.SITEURL.'admin/manage-food.php');

    }
    else
    {
       // Failed to Delete
       $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>.";
        //Redirect ot manage food page
        header('location:'.SITEURL.'admin/manage-food.php');

    }

    //4. Redirect to manage food with session message
} else {
    //Redirect to manage food page
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:' . SITEURL . 'admin/manage-food.php');
}
?>