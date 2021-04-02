<?php

session_start();
include('dbconnect.php');
include('style.php');

if (isset($_POST['submit'])) { {
    $code = $_SESSION["otp"];
    $otp = $_POST['otp'];

    if ($code == $otp) {
      echo "OTP Authentication Successful !";
      header("Location:reset_pass.php");
    } else {
      echo "Incorrect OTP .";
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
                <label for="otp">OTP</label>
                <input type="number" class="form-control" name="otp" placeholder="Enter OTP">
              </div>
              <br>
              <button type="submit" class="btn btn-primary" name="submit">Verify</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>