<?php include('partial/menu.php') ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php
        //check whether the id is set or not
        if (isset($_GET['id'])) {
            //Get the id and all other details
            //echo "get data";
            $id = $_GET['id'];
            //create sql query to get all other details
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            //Execute the Query
            $res = mysqli_query($conn, $sql);

            //count the rows to check whether the id is valid or not
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                //Get all the data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                // Redirect to manage category with session message
                $_SESSION['no-category-found'] = "<div class='error'>Category not Found.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        } else {
            //Redirect to manage category page
            header('location:' . SITEURL . 'admin/manage-category.php');
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current image</td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            //Display the image
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="100px">
                            <?php
                        } else {
                            //Dispaly message
                            echo "<div class='error'>Image Not Added.</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured</td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                            echo "checked";
                        } ?> type="radio" name="featured"
                            value="Yes">Yes
                        <input <?php if ($featured == "No") {
                            echo "checked";
                        } ?> type="radio" name="featured"
                            value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active</td>
                    <td>
                        <input <?php if ($active == "Yes") {
                            echo "checked";
                        } ?> type="radio" name="active"
                            value="Yes">Yes
                        <input <?php if ($active == "No") {
                            echo "checked";
                        } ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary ">
                    </td>
                </tr>

            </table>
        </form>

        <?php
        //check whether the submit button is clicked or not
        if (isset($_POST['submit'])) {
            // echo "Clicked";
            //1. Get all the value from form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2. updating new image if selected
            //check whether the image is selected or not
            if (isset($_FILES['image']['name'])) {
                //Get the image details
                $image_name = $_FILES['image']['name'];

                //check whether the image is available or not
                if ($image_name != "") {
                    //Image Available
                    //1. Upload the New image
        
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

                    //2. Remove the current image if Available
                    if ($current_image!="") {
                        $remove_path = "../images/category/" . $current_image;

                        $remove = unlink($remove_path);

                        //check whether the image is remove or not
                        //if failed to remove then display message and stop the process
                        if ($remove == false) {
                            //Failed to remove image
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                            header('location:' . SITEURL . 'admin/manage-category.php');
                            die(); //stop the process
                        }
                    }


                } else {
                    $image_name = $current_image;
                }
            } else {
                $image_name = $current_image;
            }


            //3. update the Database
            $sql2 = "UPDATE tbl_category SET
                 title = '$title',
                 image_name = '$image_name',
                 featured = '$featured',
                 active = '$active'
                 WHERE id=$id
            ";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //4. Redirect to manage category with message
            //check whether executed or not
            if ($res2 == true) {
                //category updated
                $_SESSION['update'] = "<div class='success'>Category Update Successfully.</div>";
                //Redirect to manage category page
                header('location:' . SITEURL . 'admin/manage-category.php');

            } else {
                //Failed to update category
                $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                //Redirect to manage category page
                header('location:' . SITEURL . 'admin/manage-category.php');
            }

        }
        ?>
    </div>

</div>
<?php include('partial/footer.php') ?>