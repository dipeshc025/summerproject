<?php include('partial/menu.php'); ?>
<div class="main_content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <?php
        //Check whether the id is set or not
        if (isset($_GET['id'])) {
            //Get all the details
            $id = $_GET['id'];

            //SQL Query to Ger the selected food
            $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //Get the value based on query executed
            $row2 = mysqli_fetch_assoc($res2);

            //Get the individual value of selected food
            $title = $row2['title'];
            $description = $row2['description'];
            $price = $row2['price'];
            $current_image = $row2['image_name'];
            $current_category = $row2['category_id'];
            $featured = $row2['featured'];
            $active = $row2['active'];
        } else {
            //REdirect to manage food
            header('location:' . SITEURL . 'admin/manage-food.php');
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($current_image == "") {
                            //Image not Available
                            echo "<div class='error'>Image Not Available.</div>";
                        } else {
                            //Image Available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="100px">

                            <?php
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php
                            //Query to get Active Category
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //Execute the Query 
                            $res = mysqli_query($conn, $sql);

                            //Count the rows 
                            $count = mysqli_num_rows($res);

                            //check whether the category is available or not
                            if ($count > 0) {
                                //Category Available
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];

                                    // echo "<option value ='$category_id'>$category_title</option>";
                                    ?>
                                    <option <?php if ($current_category == $category_id) {
                                        echo "selected";
                                    } ?>
                                        value="<?php echo $category_id; ?>"><?php echo $category_title; ?> </option>
                                    <?php
                                }
                            } else {
                                //Category Not Available
                                echo "<option value ='0'>Category Not Available</option>";
                            }

                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
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
                    <td>Active:</td>
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>


    </div>
</div>


<?php


if (isset($_POST['submit'])) {
    //echo "Button Clicked";
    //1. Get all the details from the form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $current_image = $_POST['current_image'];
    $category = $_POST['category'];

    $featured = $_POST['featured'];
    $active = $_POST['active'];


    //2. uploaad he image if selected

    //check whether the upload button is clicked or not
    if (isset($_FILES['image']['name'])) {
        //upload Button is Clicked
        $image_name = $_FILES['image']['name']; //New Image Name

        //check whether the file is available or not
        if ($image_name != "") {
            //Image is Available
            //A. uploading new image
            //Rename the image
            //Get the extension of the image
            $ext = end(explode('.', $image_name)); //Gets the extension of the Image

            $image_name = "Food-Name-" . rand(000, 999) . '.' . $ext; //This will be rename image

            //Get the source path and destination path
            $src_path = $_FILES['image']['tmp_name'];
            $des_path = "../images/food/" . $image_name;

            //upload the image
            $upload = move_uploaded_file($src_path, $des_path);


            //check whether the image is uploaded or not
            if ($upload == false) {
                //Failed to upload
                $_SESSION['upload'] = "<div class='error'>Failed to upload new image.</div>";
                //Redirect to manage Food
                header('location:' . SITEURL . 'admin/manage-food.php');
                //Stop the process
                die();
            }


            //3. Remove the Image if new image is uploaded and current image exits
            //B. Remove current image if Available
            if ($current_image != "") {
                //current image is Available
                //Remove the image
                $remove_path = "../images/food/" . $current_image;

                $remove = unlink($remove_path);

                //check whether the image is remove or not
                if ($remove == false) {
                    //failed to remove the image
                    $_SESSION['remove-failed'] = "<div class='error'>Failed to remove the image.</div>";
                    //Redirect to manage food page
                    header('locationn' . SITEURL . 'admin/manage-food.php');
                    //Stop the process
                    die();
                }
            }
        } else {
            $image_name = $current_image; //Default image when image is not selected
        }
    } else {
        $image_name = $current_image; //Default image when image Button is not clicked
    }

    //4. update the food in Database
    $sql3 = "UPDATE tbl_food SET
      title ='$title',
      description='$description',
      price=$price,
      image_name='$image_name',
      category_id='$category',
      featured='$featured',
      active='$active'
      WHERE id=$id
   ";

    //Execute the Query
    $res3 = mysqli_query($conn, $sql3);

    //check whethe rthe query is executed or not
    if ($res3 == true) {
        //Query Executed and food updated
        $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');
    } else {
        //Failed to update Food
        $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');

    }
}
?>
<?php include('partial/footer.php'); ?>