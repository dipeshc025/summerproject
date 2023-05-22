<?php include('partial/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
          if(isset($_SESSION['upload']))
          {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);

          }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food." value="">
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"
                            placeholder="Description of the Food."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php
                            //create php  code to display category from Database
                            //1. create Sql to get all active categories from database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                            $res = mysqli_query($conn, $sql);

                            //count rows to check whether we have category or not 
                            $count = mysqli_num_rows($res);

                            //If count is greater than zero, we have categories else we donot have categories
                            if ($count > 0) {
                                //We have categories
                                while ($row = mysqli_fetch_assoc($res)) {
                                    //get the details of the categories
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                  <?php
                                }
                            } else {
                                //We do not have category
                                ?>
                                <option value="0">NO Category Found</option>
                                <?php
                            }


                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php
        //check whether the button is clicked or not
        if (isset($_POST['submit'])) {

            //Add all food in database
            // echo "clicked";
        
            //1. Get the data from form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            //Checked whether the radio button for featured and active are clicked or not
            if (isset($_POST['featured'])) {
                $featured = $_POST['featured'];
            } else {
                $featured = "No"; //Setting default value
            }

            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No"; //Setting default value
            }



            //2. Upload the image if selected
            //checked whether the selected image is clicked or not and upload the image only if the image is selected
            if (isset($_FILES['image']['name'])) {
                //Get the Details od Selected images
                $image_name = $_FILES['image']['name'];

                //checked whether the image is selected or not and upload image only if selected
                if ($image_name != "") {
                    //Image is selected
                    //A. Rename the image
                    //Get the extension of selected image(jpg,pnp,gif,etc.)
                    $ext = end(explode('.',$image_name));

                    //create new name for image
                    $image_name = "Food-Name-".rand(0000,9999).".".$ext; //New image name may be "food-name-265.jpg"

                    //B. Upload the image
                    //Get the src path destination path  

                    //source path is current location of image
                    $src = $_FILES['image']['tmp_name'];

                    //Destination path for the image to be upload
                    $dst = "../images/food/".$image_name;

                    //Fianally upload the food image 
                    $upload = move_uploaded_file($src,$dst);

                    //check whether the image is upload or not
                    if($upload==false)
                    {
                        //Failed to upload the image
                        //Redirect to Add food page with error message
                        $_SESSION['upload'] = "<div class='error'>Failed to upload the image.</div>";
                        header('location:'.SITEURL.'admin/add-food.php');
                        //Stop the process
                        die();
                    }
                }
            } else {
                $image_name = ""; //Setting default value blank
            }

            //3. Insert into database

            //create a SQL Query to save or Add food
            //For the numeric we donot pass value inside quotes '' but string value it is compulsary
            $sql2 = "INSERT INTO tbl_food SET
                title='$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
            ";

            //Execute the Query 
            $res2 = mysqli_query($conn,$sql2);

            //check whether the data is insert or not
            //4. Redirect with message to manage food page
            if($res2==true)
            {
                //Data insert Successfully
                $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                //Failed to insert Data
                $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
        
        }
        ?>
    </div>
</div>

<?php include('partial/footer.php') ?>