<?php include('partial/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1><br><br>

        <?php
        if (isset($_SESSION['add'])) //Checking Whether the session is set or not
        {
            echo $_SESSION['add']; //Displaying the Session Message if SET
            unset($_SESSION['add']); //Removing Session Message
        }


        ?>
        <form action="#" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name:" required>
                    </td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username:" required>
                    </td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder=" Your password:" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>

<?php include('partial/footer.php') ?>

<?php

//process the value from form and save it in database

//check whether the submit button is clicked or not

if (isset($_POST['submit'])) {
    //Button Clicked

    //1. Get the data from the form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //password Encryption with md5

    //2. SQL Query to save data from database
    $sql = "INSERT INTO tbl_admin SET
    full_name='$full_name',
    username='$username',
    password='$password'  
    ";


    //3.Executing query and saving into database

    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    //Check Whether the Query is Excuted or not and display appropriate message

    if ($res == TRUE) {
        //data inserted
        //echo"Data inserted";
        //create a variable to display message
        $_SESSION['add'] = "<div class='success'>Admin Added Successfully.</div>";
        //REdirect page
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        //failed to insert data
        //echo"Failed to insert data";
        //create a variable to display message
        $_SESSION['add'] = "<div class='error'>Failed to Add Admin.</div>";
        //REdirect page
        header("location:" . SITEURL . 'admin/add-admin.php');
    }
}



?>