<?php include('partial/menu.php') ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>


        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">

                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php
//Check Whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    //echo "Clicked";

    //1. Get the data from the form
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    //2. check whether the user  with current id and current password Exists or not
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

    //Execute the Query
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        //check Whether data is available or not
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            //user Exists and password can be changed
            // echo "User Found";

            if ($new_password == $confirm_password) {

                //Update the password
                $sql2 = "UPDATE tbl_admin SET
                  password='$new_password'
                  WHERE id=$id
                ";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //check whether the query is executed or not
                if ($res2 == true) {
                    //Dispaly Success Message 
                    //Redirect to manage Admin page with success message
                    $_SESSION['change-pwd'] = "<div class= 'success'>Password Changed Successfully.</div>";

                    //redirect the user
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                } else {
                    //Display erroe Message
                    //Redirect to manage Admin page with error message
                    $_SESSION['change-pwd'] = "<div class= 'error'>Failed to change password.</div>";

                    //redirect the user
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            } else {
                //Redirect to manage Admin page with error message
                $_SESSION['pwd-not-match'] = "<div class= 'error'>Password Did Not Match.</div>";

                //redirect the user
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        } else {
            //user Does not Exists set message and redirect
            $_SESSION['user-not-found'] = "<div class= 'error'>User Not Found.</div>";

            //redirect the user
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }
    }
}



?>

<?php include('partial/Footer.php') ?>