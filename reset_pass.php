<?php

session_start();
include('dbconnect.php');
include('style.php');

if (mysqli_connect_error()) {
  echo "Failed to connect !" . mysqli_connect_error();
  exit();
} else {
  if (isset($_POST['submit'])) { {
      $pass = $_POST['pass'];
      $con_pass = $_POST['con_pass'];
      $mail = $_SESSION["reset_mail"];

      if ($pass == $con_pass) {
        $query = "UPDATE `registration` SET password='$pass' WHERE email='$mail'";
        mysqli_query($con, $query);
        header("Location:index.php");
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
                <h1>OTP Verification</h1>
                <label for="pass">New Password</label>
                <input type="password" class="form-control" name="pass" placeholder="Enter New Password">
              </div>

              <div class="form-group">
                <label for="con_pass">Confirm Password</label>
                <input type="password" name="con_pass" class="form-control" placeholder="Enter Confirm Password">
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