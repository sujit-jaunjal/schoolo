<?php
include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $email = $_SESSION['email'];

    $query = "SELECT * FROM `registration` WHERE email='$email'";
    $out = mysqli_query($con, $query);

    if ((mysqli_num_rows($out) > 0)) {
        while (($row = mysqli_fetch_assoc($out))) {
            $final = $row;
        }
    }
    $id = $final['id'];

    if (isset($_POST['submit'])) {
        $filename = $_FILES['uploadfile']['name'];
        $tmp_name = $_FILES['uploadfile']['tmp_name'];
        $folder = "profile/" . $filename;
        move_uploaded_file($tmp_name, $folder);

        $resultant = "UPDATE `registration` SET image='$folder' WHERE id='$id'";
        mysqli_query($con, $resultant);
        echo "<script>window.location.href='myprofile.php';</script>";
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

<div class="container-fluid" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card-group">
                <div class="card"">
                    <div class=" alert alert-primary" role="alert">
                    <h2 style="font-family:serif;">Change Profile Pic -</h2>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                            <input id="upload" name="uploadfile" type="file" onchange="readURL(this);" class="form-control border-0">
                            <label id="upload-label" for="upload" class="font-weight-light text-muted"></label>
                            <div class="input-group-append">
                                <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                            </div>
                        </div>

                        <img id="imageResult" src="images/anonymous.png" alt="" style="height: 250px; width:250px;" class="rounded-circle img-fluid rounded shadow-sm mx-auto d-block">
                        <br>
                        <br>
                        <center><button type="submit" class="btn btn-primary" name="submit">Change Pic</button></center>
                    </form>
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