<?php

include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {
    $email = $_SESSION['email'];
    $query = "SELECT * FROM `registration` WHERE email='$email'";

    $out = mysqli_query($con, $query);

    if (isset($_POST['upload'])) {
        $filename = $_FILES['uploadfile']['name'];
        $tmp_name = $_FILES['uploadfile']['tmp_name'];
        $folder = "profile/" . $filename;
        move_uploaded_file($tmp_name, $folder);

        if ($folder != "profile/") {
            $res = "UPDATE `registration` SET image='$folder' WHERE email='$email'";
            mysqli_query($con, $res);
        }
    }

    if ((mysqli_num_rows($out) > 0)) {
        while (($row = mysqli_fetch_assoc($out))) {
            $final = $row;
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
                                            <?php include('image.php'); ?>
                                        </label>
                                        <input id="file-input" type="file" name="uploadfile" /><br>
                                        <center> <input type="submit" class="btn btn-primary" title="Click on pic to change it !" value="Change Profile Pic" name="upload"></center>
                                    </div>
                                </center>
                                <div class="form-group">
                                    <label for="name">Name :</label>
                                    <input type="text" class="form-control" style="background-color:white;" value="<?php echo $final['name'] ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" style="background-color:white;" value="<?php echo $final['email'] ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="mobile">Mobile No :</label>
                                    <input type="number" class="form-control" style="background-color:white;" value="<?php echo $final['phone_no'] ?>" readonly>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
        </div>
    </div>
</div>
<?php

include('footer.php');

?>