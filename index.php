<?php include('partial-font/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php 
  if(isset($_SESSION['order']))
  {
    echo $_SESSION['order'];
    unset($_SESSION['order']);
  }

?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        //create SQL Query to Display Categories from Database
        $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
        //Execute the Query
        $res = mysqli_query($conn, $sql);
        //count rows to check whether the categoty is available or not
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            //categories Available
            while ($row = mysqli_fetch_assoc($res)) {
                //get the value like id,title,image_name
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
                ?>
                <a href="<?php echo SITEURL;?>category-foods.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container">
                        <?php
                        //check whether the image is Available or not
                        if ($image_name == "") {
                            //Dispaly message
                            echo "<div class='error'>Image not Available.</div>";
                        } else {
                            //Image Avalable
                            ?>

                            <img src="<?php SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza"
                                class="img-responsive img-curve">
                            <?php
                        }
                        ?>

                        <h3 class="float-text text-white">
                            <?php echo $title; ?>
                        </h3>
                    </div>
                </a>


                <?php

            }
        } else {
            //ccategories noe Available
            echo "<div class='error'>category not Added.</div>";
        }
        ?>



        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<!-- FOOD Menu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        //Getting food from Database that are active and featured
        //SQL Query
        $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";
        //execute the Query
        $res2 = mysqli_query($conn, $sql2);

        //Count Rows
        $count2 = mysqli_num_rows($res2);

        //check  whether food available or not
        if ($count > 0) {
            //Food Available
            while ($row = mysqli_fetch_assoc($res2)) {
                //Get all the value
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $description = $row['description'];
                $image_name = $row['image_name'];
                ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        //check whether the image available or not
                        if ($image_name == "") {
                            //Image Not Available
                            echo "<div class='error'>Image Not Available.</div>";

                        } else {
                            //Image Available
                            ?>

                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>"  class="img-responsive img-curve">
                            <?php
                        }
                        ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4>
                            <?php echo $title; ?>
                        </h4>
                        <p class="food-price">RS:
                            <?php echo $price; ?>
                        </p>
                        <p class="food-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>

                        <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
                <?php
            }
        } else {
            //Food Not Available
            echo "<div class='error'>Food not Added.</div>";

        }
        ?>





        <div class="clearfix"></div>



    </div>

    <p class="text-center">
        <a href="#">See All Foods</a>
    </p>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partial-font/footer.php'); ?>