<html>
<?php

session_start();
include('dbconnect.php');
include('style.php');


if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
} else {
  if (isset($_POST['Submit'])) {

    $email = $_POST['email'];
    $passwd = $_POST['password'];

    $final = array();

    $query = "SELECT email,password FROM `registration` WHERE email='$email'";
    $out = mysqli_query($con, $query);

    if ((mysqli_num_rows($out) > 0)) {
      while (($row = mysqli_fetch_assoc($out))) {
        $final = $row;
      }
    }
    if ($final['password'] == $passwd) {
      $_SESSION["email"] = $_POST['email'];
      header("Location:feed.php");
    } else {
      echo '<script>alert("Invalid username or password !")</script>';
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
                <center>
                  <h1 style="font-family:serif;">Welcome to Schoolo !</h1>
                </center>
                <br>
                <h2>Login -</h2>
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" placeholder="Enter email" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
              </div>

              <small>Don't have an account ?</small>
              <a href="regis.php">Sign Up</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <small>Forgot Password ?</small>
              <a href="forgot.php">Click Here</a>
              <br>
              <br>
              <center> <button type="submit" class="btn btn-primary" name="Submit">Submit</button></center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>