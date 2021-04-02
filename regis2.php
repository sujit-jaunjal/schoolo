<html>
<?php

session_start();
include('dbconnect.php');
include('style.php');


if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
} else {

    $email = $_SESSION['regis_mail'];
    $final = array();

    $query = "SELECT *FROM `registration` WHERE email='$email'";
    $out = mysqli_query($con, $query);

    if ((mysqli_num_rows($out) > 0)) {
        while (($row = mysqli_fetch_assoc($out))) {
            $final = $row;
        }
    }

    if (isset($_POST['submit'])) {

        $filename = $_FILES['uploadfile']['name'];
        $tmp_name = $_FILES['uploadfile']['tmp_name'];
        $folder = "profile/" . $filename;
        move_uploaded_file($tmp_name, $folder);

        $avatar = $_POST['avatar'];
        $about = $_POST['about'];
        $anonymous_id = 'anonymous_' . $avatar;
        $check1 = "SELECT avatar FROM `registration` WHERE avatar='$avatar'";
        $out1 = mysqli_query($con, $check1);
        if ((mysqli_num_rows($out1) > 0)) {
            echo '<script>alert("Avatar name Taken !")</script>';
        } else {
            $res = "UPDATE `registration` SET image='$folder', avatar='$avatar', anonymous_id='$anonymous_id', about='$about' WHERE email='$email'";
            mysqli_query($con, $res);
            echo "<script>alert('Registered Successfully ! Please login..');</script>";
            header('Location:login.php');
        }
    }
}

?>

<style>
    #upload {
        opacity: 0;
    }

    #upload-label {
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
    }

    .image-area {
        border: 2px dashed rgba(255, 255, 255, 0.7);
        padding: 1rem;
        position: relative;
    }

    .image-area::before {
        content: 'Uploaded image ';
        color: #000;
        font-weight: bold;
        text-transform: uppercase;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 0.8rem;
        z-index: 1;
    }

    .image-area img {
        z-index: 2;
        height: 300px;
        width: 300px;
        position: relative;
    }
</style>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imageResult')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(function() {
        $('#upload').on('change', function() {
            readURL(input);
        });
    });
</script>

<body style="background-color:#000000;">

    <div class="container">
        <div class="card" style="margin-top:100px; background-image : url('images/bg.jpg');">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <h1>Profile -</h1>
                            <img id="imageResult" src="images/anonymous.png" alt="" style="height: 250px; width:250px;" class="rounded-circle img-fluid rounded shadow-sm mx-auto d-block">
                            <br>
                            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                <input id="upload" name="uploadfile" type="file" onchange="readURL(this);" class="form-control border-0">
                                <label id="upload-label" for="upload" class="font-weight-light text-muted"></label>
                                <div class="input-group-append">
                                    <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="name">Avatar Name :</label>
                                <input type="text" class="form-control" name="avatar" placeholder="Enter Avatar Name">
                            </div>
                            <div class="form-group">
                                <label for="about">Bio :</label>
                                <textarea name="about" class="form-control" placeholder="About Yourself..."></textarea>
                            </div>
                            <br>
                            <br>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

</html>