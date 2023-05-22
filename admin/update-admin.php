<?php include('partial/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php
        //1. Get the ID of Selected Admin
        $id = $_GET['id'];

        //2. Create SQL Query to Get the Details
        $sql = " SELECT * FROM tbl_admin WHERE id= $id ";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //check whether the Query is executed or not
        if ($res == true) {
            //check whether the data ia available or not
            $count = mysqli_num_rows($res);

            //check whether have admin data or not
            if ($count == 1) {
                //Get the Details
                //echo "Admin Available";
                $row = mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];
            } else {
                //Redirect to manage Admin page
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        }

        ?>


        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>FUll Name</td>
                    <td>
                        <input type="text" name="full_name" Value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" Value="Add Admin" class="btn-secondary">

                    </td>
                </tr>


            </table>
        </form>

    </div>
</div>

<?php
//check whether the submit Button is clicked or not
if (isset($_POST['submit'])) {
    //echo "Button Clicked";
    //Get all the value from form to update
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    //create a sql Query to update admin
    $sql = "UPDATE tbl_admin SET
   full_name='$full_name',
   username='$username'
   WHERE id='$id'
   ";

    //Execute the Query
    $res = mysqli_query($conn, $sql);


    //Check Whether the Query is Excuted or not
    if ($res == true) {
        //Query Execute and Admin Update
        $_SESSION['update'] = "<div class='success'>Admin Update Successfully.</div>";
        //REdirect page
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        //failed to update Admin
        $_SESSION['update'] = "<div class='error'>Failed to Update Admin.</div>";
        //REdirect page
        header("location:" . SITEURL . 'admin/add-admin.php');
    }






}
?>

<?php include('partial/footer.php'); ?>