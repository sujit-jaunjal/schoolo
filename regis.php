<html>
<?php

session_start();
include('dbconnect.php');
include('style.php');


if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
} else {
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $passwd = $_POST['password'];
    $con_passwd = $_POST['con_password'];
    $date = $_POST['date'];

    $gender = $_POST['gender'];
    if ($gender == 'male') {
      $gender = '0';
    } else if ($gender == 'female') {
      $gender = '1';
    } else {
      $gender = '2';
    }

    $check = "SELECT email FROM `registration` WHERE email='$email'";
    $out = mysqli_query($con, $check);
    if ((mysqli_num_rows($out) > 0)) {
      echo '<script>alert("Already Registered !")</script>';
    } else {
      if ($passwd == $con_passwd) {
        $query = "INSERT INTO registration(name, avatar, anonymous_id, password, about, dob, email, phone_no, gender, image,skills,modal) VALUES ('$name','','','$passwd','','$date','$email','$mobile','$gender','','','0');";
        mysqli_query($con, $query);

        $_SESSION['regis_mail'] = $email;
        header("Location:regis2.php");
      } else {
        echo "Failed to upload data";
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
              <h1>Register -</h1>
              <div class="form-group">
                <label for="name">Name :</label>
                <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
              </div>
              <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" placeholder="Enter email" required>
              </div>
              <div class="form-group">
                <label for="mobile">Mobile No :</label>
                <input type="number" class="form-control" name="mobile" placeholder="Enter Mobile No.." required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
              </div>
              <div class="form-group">
                <label for="con_password">Confirm Password</label>
                <input type="password" class="form-control" name="con_password" placeholder="Confirm Password" required>
              </div>
              <div class="form-group">
                <label for="DOB">Date of Birth -</label>
                <input type="date" class="form-control" name="date" required>
              </div>
              <div class="form-group">
                <label for="gender">Gender :</label>
                <input type="radio" name="gender" value="male" checked>
                <label>Male</label>&nbsp&nbsp&nbsp
                <input type="radio" name="gender" value="female">
                <label>Female</label>&nbsp&nbsp&nbsp
                <input type="radio" name="gender" value="other">
                <label>Other</label>
                </br>
                <br>
              </div>
              <small>Already have an account ?</small>
              <a href="index.php">Sign In</a>
              <br>
              <br>
              <button type="submit" class="btn btn-primary" name="submit">Next</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>