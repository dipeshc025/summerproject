<?php include('../config/constants.php'); ?>

<html>

<head>
    <title>Login Food order system</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>

        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }


        ?>
        <br><br>

        <!--Login Form Start Here-->
        <form action="" method="POST" class="text-center">
            Username:<br>
            <input type="text" name="username" placeholder="Enter Your Username:"><br><br>
            Password:<br>
            <input type="password" name="password" placeholder="Enter Your password:"><br><br>

            <input type="submit" name="submit" value="Login" >
            <br><br><br>
        </form>
        <!--Login Form Ends Here-->

        <p class="text-center">Created By: <a href="www.dipesh.com">Dipesh Katwal</a></p>

    </div>
</body>

</html>

<?php
//check whether the submit button is Clicked or Not
if (isset($_POST['submit'])) {
    //process for Login
    //1.Get the data fron Login form
   // $username = $_POST['username'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    //2. SQL to check whether the user with username and password exits or not
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    //Execute the query
    $res = mysqli_query($conn, $sql);

    //4. cunt rows to check whether the user exits or not
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        //User Available and Login Success
        $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
        $_SESSION['user'] = $username; // to check whether the user is Logged in or Not and Logout will unset it
        //Redirect to Home page/DAshboard
        header('location:' . SITEURL . 'admin/');
    } else {
        //User not Available and Login failed
        $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
        //Redirect to Home page/DAshboard
        header('location:' . SITEURL . 'admin/login.php');
    }
}
?>