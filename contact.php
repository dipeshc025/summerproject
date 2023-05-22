<?php include('partial-font/menu.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Restaurant Contact Form</title>
</head>
<h2 class="text-center">Contact Us</h2>
<hr>
<?php
  if(isset($_SESSION['contact']))
  {
    echo $_SESSION['contact'];
    unset($_SESSION['contact']);
  }
?>

<form action="" method="POST" class="order" style=" background-image: url('images/bg.jpg');">
    <table>
        <tr>
            <td class="order-label">FullName:</td>
            <td>
                <input type="text" name="full_name" placeholder="Enter your fullname:" class="input-responsive"
                    required>
            </td>
        </tr>

        <tr>
            <td class="order-label">Phone Number:</td>
            <td>
                <input type="tel" name="contact" placeholder="eg: 98xxxxxxxx" class="input-responsive" required>
            </td>
        </tr>

        <tr>
            <td class="order-label">Email:</td>
            <td>
                <input type="email" name="email" placeholder="eg: abcxx@gmail.com" class="input-responsive" required>
            </td>
        </tr>

        <tr class="order-label">
            <td>Address:</td>
            <td>

                <textarea name="address" placeholder="E.g. Street, City, Country" class="input-responsive"
                    required></textarea>
            </td>
        </tr>

        <tr class="order-label">
            <td>Queries</td>
            <td>

                <textarea name="queries" placeholder="Placed Your Queries Here" class="input-responsive"
                    required></textarea>
            </td>
        </tr>

        <tr>
            <td>

                <input type="submit" name="submit" value="Message US" class="btn btn-primary">
            </td>
        </tr>

    </table>
</form>
</body>

</html>
<br><br>

<?php include('partial-font/footer.php'); ?>

<?php
//check whether the button is clicked or not
if (isset($_POST['submit'])) {
   // echo "Button clicked";
   //1.Get the data from the form
   $full_name = $_POST['full_name'];
   $contact = $_POST['contact'];
   $email = $_POST['email'];
   $address = $_POST['address'];
   $queries = $_POST['queries'];

    // SQL Query to Save the data into Database
    $sql = "INSERT INTO tbl_contact SET
      full_name='$full_name',
      contact='$contact',
      email='$email',
      address='$address',
      queries='$queries'

     ";


    //Execute the Query 
    $res = mysqli_query($conn,$sql)  or die(mysqli_error());

    //check whether the query executed or not
    if ($res == true) {
        //Query Executed and order saved
        $_SESSION['contact'] = "<div class='success text-center'>Message Send Successfully.</div>";
        header('location:' . SITEURL);
    } else {
        //Failed to Saved order
        $_SESSION['contact'] = "<div class='error text-center'>Failed to send the Message.</div>";
        header('location:' . SITEURL);
    }
}
?>