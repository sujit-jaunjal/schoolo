<?php
include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $email = $_SESSION['email'];
    $_SESSION['like_from'] = false;
    $run = "SELECT * FROM `registration` WHERE email='$email'";

    $result = mysqli_query($con, $run);

    if ((mysqli_num_rows($result) > 0)) {
        while (($row = mysqli_fetch_assoc($result))) {
            $final = $row;
        }
    }
    $avatar = $final['avatar'];

    $id = $final['id'];

    $req = "SELECT * FROM `post` WHERE user_id='$id' ORDER BY id DESC";
    $re = mysqli_query($con, $req);
    $num = mysqli_num_rows($re);

    if (isset($_POST['like'])) {
        $pic_time = $_POST['like'];
        $like = "INSERT INTO post(user_id, image, caption, image_timestamp, like_from) VALUES('','','','$pic_time', '$avatar')";
        mysqli_query($con, $like);
    }

    if (isset($_POST['dislike'])) {
        $pic_time = $_POST['dislike'];
        $dislike = "DELETE FROM post WHERE image_timestamp='$pic_time' AND like_from='$avatar'";
        mysqli_query($con, $dislike);
    }

    if (isset($_POST['del_pt'])) {
        $pt = $_POST['del_pt'];
        $del_pt = "DELETE FROM post WHERE image_timestamp='$pt'";
        mysqli_query($con, $del_pt);
    }
}
?>

<style>
    #th {
        border: 1px solid lightblue;
    }
</style>

<div class="container-fluid" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card-group">
                <div class="card">
                    <div class="alert alert-primary" role="alert">
                        <h2 style="font-family:serif;">My Posts -</h2>
                    </div>
                    <div class="card-body" style="overflow-y:scroll;">
                        <?php
                        if ($num != null) {
                            while (($row = mysqli_fetch_assoc($re))) {
                        ?>
                                <div class="form-group" id="th">
                                    <center><img src="<?php echo $row['image'] ?>" height="150" width="240" class="img-fluid"></center><br><br>
                                    <?php
                                    $timestamp = $row['image_timestamp'];
                                    $cap = $row['caption'];
                                    $find = "SELECT distinct(like_from) FROM post where image_timestamp='$timestamp' AND like_from!='0'";
                                    $fnd = mysqli_query($con, $find);
                                    $cnt = mysqli_num_rows($fnd);
                                    if ((mysqli_num_rows($fnd) > 0)) {
                                        while (($row = mysqli_fetch_assoc($fnd))) {
                                            $fnd_pic = $row;
                                            if ($avatar == $fnd_pic['like_from']) {
                                                $_SESSION['like_from'] = true;
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                    <form method="POST">
                                        <?php
                                        if ($_SESSION['like_from'] == false) {
                                            $_SESSION['like_tp'] = $timestamp;
                                        ?>
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <button class="btn btn-primary" style="background-color: white; color:blue;" value="<?php echo $timestamp; ?>" type="submit" name="like"><i class="fa fa-thumbs-up" aria-hidden="true"></i></button></div><br><br>
                                                <div class="col-md-3"><a href="likes_from.php"><?php echo $cnt; ?> Likes</a><br><br></div>
                                                <div class="col-md-8"></div>
                                            </div>
                                        <?php
                                        } else {
                                            $_SESSION['like_tp'] = $timestamp;
                                        ?>
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <button class="btn btn-primary" value="<?php echo $timestamp; ?>" type="submit" name="dislike"><i class="fa fa-thumbs-up" aria-hidden="true"></i></button></div><br><br>
                                                <div class="col-md-3"><a href="likes_from.php"><?php echo $cnt; ?> Likes</a><br><br></div>
                                                <div class="col-md-8"></div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <hr>
                                        <u> <b>Caption</b></u> -<br> <?php echo $cap; ?><br><br>
                                        <?php
                                        $datetimeFormat = 'Y-m-d H:i';

                                        $date = new \DateTime();
                                        $date->setTimestamp($timestamp + '19800');
                                        ?>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <small><b>Posted on</b> -<br> <?php echo $date->format($datetimeFormat); ?><br><br></small>
                                            </div>
                                            <div class="col-md-6"></div>
                                            <div class="col-md-3">
                                                <button class="btn btn-primary" name="del_pt" style="background-color: lightcoral;" value="<?php echo $timestamp; ?>">Delete this post</button>
                                            </div>
                                        </div><br>
                                    </form>
                                </div>
                                <hr>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include('footer.php');
?>