<?php

include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $email = $_SESSION['email'];

    $que = "SELECT * FROM education WHERE email='$email'";


    $val = mysqli_query($con, $que);

    $num = mysqli_num_rows($val);


    echo '<pre>';
    print_r($row);
    echo '</pre>';


    $query = "SELECT *FROM `registration` WHERE email='$email'";
    $_SESSION['update'] = false;
    $out = mysqli_query($con, $query);

    if ((mysqli_num_rows($out) > 0)) {
        while (($row = mysqli_fetch_assoc($out))) {
            $final = $row;
        }
    }
    $id = $final['id'];
    $ava = $final['avatar'];

    $educ = "SELECT * FROM `education` WHERE id='$id'";
    $exe = mysqli_query($con, $educ);

    if ((mysqli_num_rows($exe) > 0)) {
        while (($row = mysqli_fetch_assoc($exe))) {
            $edu = $row;
        }
    }

    if (isset($_POST['update'])) {
        $_SESSION['update'] = true;
    }

    if (isset($_POST['profile'])) {
        echo "<script>window.location.href='change_profile.php';</script>";
    }

    if (isset($_POST['save'])) {
        $_SESSION['update'] = false;
        $avatar = $_POST['avatar'];
        $name = $_POST['name'];
        $update_about = $_POST['update_about'];
        $phone = $_POST['mobile'];
        $skills = $_POST['skills'];


        if ($ava == $avatar) {
            $run = "UPDATE `registration` SET avatar='$avatar',name='$name', about='$update_about',  phone_no='$phone', skills='$skills' WHERE email='$email'";
            mysqli_query($con, $run);
            echo "<script>alert('Information updated !')</script>";
        } else {
            $check1 = "SELECT avatar FROM `registration` WHERE avatar='$avatar'";
            $out1 = mysqli_query($con, $check1);
            if ((mysqli_num_rows($out1) > 0)) {
                echo '<script>alert("Avatar name Taken !")</script>';
            } else {
                $run = "UPDATE `registration` SET avatar='$avatar',name='$name', about='$update_about',  phone_no='$phone', skills='$skills' WHERE email='$email'";
                mysqli_query($con, $run);
                echo "<script>alert('Information updated !')</script>";
            }
        }
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card-group">
                <div class="card">
                    <div class="form">
                        <div class="card-body">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <center>
                                    <div class="image-upload">

                                        <label for="file-input">
                                            <?php
                                            include('image.php');
                                            ?>
                                        </label>
                                    </div>

                                    <button class="btn btn-primary" name="profile">Change Pic</button>
                                </center>
                            </form>
                            <div class="back">
                                <form method="POST">

                                    <?php
                                    if ($_SESSION['update'] == true) {
                                    ?>
                                        <div class="form-group">
                                            <label for="name"><b>Avatar Name :</b></label>
                                            <input type="text" name="avatar" class="form-control" value="<?php echo $final['avatar'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="name"><b>Name :</b></label>
                                            <input name="name" class="form-control" value="<?php echo $final['name'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="about"><b>About :</b></label>
                                            <textarea name="update_about" class="form-control"><?php echo $final['about'] ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="email"><b>Email address</b></label>
                                            <input type="email" name="update_email" class="form-control" value="<?php echo $final['email'] ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="education"><b>Education :</b></label>
                                            <div class="row">
                                                <div class="col-md-10">
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="education.php" class="btn btn-primary" role="button"><i class="fas fa-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                            <div class="form-group">
                                <label for="skill"><b>Skills :</b></label>
                                <textarea name="skills" class="form-control" style="background-color:white;"><?php echo $final['skills']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="save">Save Info</button>
                            </div>
                        <?php
                                    } else {
                        ?>
                            <div class="form-group">
                                <label for="name"><b>Avatar Name :</b></label>
                                <input type="text" name="avatar" style="background-color:white;" class="form-control" value="<?php echo $final['avatar'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="name"><b>Name :</b></label>
                                <input type="text" class="form-control" style="background-color:white;" value="<?php echo $final['name'] ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="about"><b>About :</b></label>
                                <textarea name="update_about" style="background-color:white;" class="form-control" readonly><?php echo $final['about'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="email"><b>Email address</b></label>
                                <input type="email" class="form-control" style="background-color:white;" value="<?php echo $final['email'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="education"><b>Education :</b></label>
                                <?php

                                        if ($num == null) {
                                ?>
                                    <textarea name="education" class="form-control" style="background-color:white;" readonly></textarea>
                            </div>
                            <?php
                                        } else {
                                            while (($row = mysqli_fetch_assoc($val))) {
                            ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="images/college.png" alt="User Image" width="50" height="60">
                                        </div>
                                        <div class="col-md-6">
                                            <?php echo $row['school']; ?><br>
                                            <?php echo $row['degree']; ?>, <?php echo $row['edu_field']; ?>
                                        </div>
                                        <div class="col-md-5"></div>
                                    </div>
                                </div>
                        <?php
                                            }
                                        }
                        ?>
                        <div class="form-group" style="white-space: pre-line;">
                            <label for="skill"><b>Skills :</b></label>
                            <textarea name="skills" class="form-control" style="background-color:white;" readonly><?php echo $final['skills']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="update">Edit Info</button>
                        </div>
                    <?php
                                    }
                    ?>
                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
    </div>
</div>
</div>

<script>
    function edu() {
        window.location.href = "education.php";
    }
</script>

<?php

include('footer.php');

?>