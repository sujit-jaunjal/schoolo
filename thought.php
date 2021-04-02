<?php

include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $email = $_SESSION['email'];
    $query = "SELECT *FROM `registration` WHERE email='$email'";

    $res = mysqli_query($con, $query);

    if ((mysqli_num_rows($res) > 0)) {
        while (($row = mysqli_fetch_assoc($res))) {
            $final = $row;
        }
    }
    $id = $final['id'];

    if (isset($_POST['submit'])) {

        $mood = $_POST['mood'];
        $thoughts = $_POST['thoughts'];
        $timestamp = time();
        $query = "INSERT INTO thought(user_id, mood, thoughts, timestamp) VALUES ('$id','$mood', '$thoughts', '$timestamp');";
        mysqli_query($con, $query);
        echo "<script>alert('Thoughts Saved...');</script>";
        echo "<script>window.location.href='myprofile.php';</script>";
    }
}
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <div class="card-group" style="margin-top: 100px;">
                <div class="card">
                    <div class="alert alert-primary" role="alert">
                        Express your thoughts !
                    </div>
                    <div class="form">
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="mood">What Special ?</label>
                                    <select class="form-control" name="mood">
                                        <option>Nothing much..</option>
                                        <option>Funday</option>
                                        <option>Motivational</option>
                                        <option>Sunset</option>
                                        <option>Lockdown thoughts</option>
                                    </select>
                                </div><br>
                                <div class="form-group">
                                    <label for="thought"><b>Express thoughts :</b></label>
                                    <textarea name="thoughts" class="form-control" style="height: 100px;"></textarea>
                                </div><br>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="submit">Save</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
        </div>
    </div>
</div>


<?php
include('footer.php');
?>