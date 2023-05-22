<?php include('partial/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        ?>

        <br><br>



        <!--Add Category form start here-->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" placeholder="category title">
                    </td>
                </tr>

                <tr>
                    <td>Select image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!--Add Category form ends here-->

        <?php
        //check whether the submit button is Clicked or not
        if (isset($_POST['submit'])) {
            //echo "Clicked";
            //1. Get the value from form
            $title = $_POST['title'];

            //For Radio button We have to check whether the  button is selected or not
            if (isset($_POST['featured'])) {
                //Get the value from form
                $featured = $_POST['featured'];

            } else {
                //Set the default value
                $featured = "NO";
            }

            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No";
            }

            //check whether the image is select or not and set the value for image nane accordingly
            // print_r($_FILES['image']);
        
            //die(); //Break the code here
        
            if (isset($_FILES['image']['name'])) {
                //Upload the image
                //To upload image we nee image name, source path and destination path
                $image_name = $_FILES['image']['name'];

                //upload the image only if object is selected
                if ($image_name != "") {

                    //Auto rename our image
                    //Get the extension of our image(img, png, gif,etc)eg: "food.jpg"
                    $ext = end(explode('.', $image_name));

                    //Rename the image
                    $image_name = "Food_category" . rand(000, 999) . '.' . $ext; //eg: Food_category_321.jpg
        
                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/" . $image_name;

                    //Finally upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //check whether the image upload or not
                    //if the image is not upload then we will stop the proces and redirect with error message
                    if ($upload == false) {
                        //set message
                        $_SESSION['upload'] = "<div class='success'>Failed to upload the image.</div>";
                        //Redirect ot Add category page
                        header('location:' . SITEURL . 'admin/add-category.php');
                        //Stop the process
                        die();
                    }

                }
            } else {
                //Don't upload the image and set the image value as blank
                $image_name = "";
            }

            //2. Create SQL Query to insert Database
            $sql = "INSERT INTO tbl_category SET
                     title='$title',
                     image_name='$image_name',
                     featured='$featured',
                     active='$active'
            ";

            //3. Execute the Query and save into database
            $res = mysqli_query($conn, $sql);

            //4. check whether the query executed or not and data added or not
            if ($res == true) {
                //Query Executed and category Added
                $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                //Redirect to manage category page
                header("location:" . SITEURL . 'admin/manage-category.php');
            } else {
                //failed to Add Category
                $_SESSION['add'] = "<div class='error'>Failed To Add Category.</div>";
                //Redirect to manage category page
                header("location:" . SITEURL . 'admin/add-category.php');

            }
        }
        ?>
    </div>
</div>


<?php include('partial/footer.php'); ?>