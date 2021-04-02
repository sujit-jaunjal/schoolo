<html>
<?php

session_start();
include('style.php');
include('dbconnect.php');

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
} else {

  if (isset($_POST['submit'])) {
    $email = $_POST['email'];


    $final = array();

    $query = "SELECT email FROM `registration` WHERE email='$email'";
    $out = mysqli_query($con, $query);

    if ((mysqli_num_rows($out) == 0)) {
      echo "<script>alert('No user Registered with this mail id !')</script>";
    } else {
      $subject = "Reset Password. Hi, This is verification code to reset password - ";
      $body = rand(10000, 100000);
      $headers = "From: sender\'s email";

      if (mail($email, $subject, $body, $headers)) {
        echo "Email successfully sent...";
        $_SESSION["otp"] = $body;
        $_SESSION["reset_mail"] = $email;
        header("Location:otp.php");
      } else {
        echo "Email sending failed...";
      }
    }
  }
}
?>

<body style="background-color:#000000;">

  <div class="container">
    <div class="card" style="margin-top:100px; background-image : url('images/bg.jpg');">
      <div class="card-body">
        <div class="row">
          <div class="col-md-2">
          </div>
          <div class="col-md-8">

            <form method="POST">
              <div class="form-group">
                <h1>Forgot Password ? </h1>
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" placeholder="Enter email">
              </div>

              <br>
              <button type="submit" class="btn btn-primary" name="submit">Send Verification</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>