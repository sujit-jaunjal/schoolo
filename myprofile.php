<?php

include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    if (isset($_POST['del_pt'])) {
        $pt = $_POST['del_pt'];
        $del_pt = "DELETE FROM post WHERE image_timestamp='$pt'";
        mysqli_query($con, $del_pt);
    }

    if (isset($_POST['del_th'])) {
        $del_th = $_POST['del_th'];
        $del_tho = "DELETE FROM thought WHERE timestamp='$del_th'";
        mysqli_query($con, $del_tho);
    }

    $email = $_SESSION['email'];
    $_SESSION['like_tp'] = null;
    $_SESSION['like_from'] = false;
    $query = "SELECT *FROM `registration` WHERE email='$email'";

    $res = mysqli_query($con, $query);

    if ((mysqli_num_rows($res) > 0)) {
        while (($row = mysqli_fetch_assoc($res))) {
            $final = $row;
        }
    }
    $edu = "SELECT * FROM `education` WHERE email='$email'";
    $val = mysqli_query($con, $edu);
    $num = mysqli_num_rows($val);


    $id = $final['id'];
    $avatar = $final['avatar'];

    $request = "SELECT distinct(user_id) FROM `connections` where my_connections='$id'
    UNION
    SELECT distinct(my_connections) FROM `connections` where user_id='$id'";
    $res1 = mysqli_query($con, $request);
    $num1 = mysqli_num_rows($res1);

    if (isset($_POST['thought'])) {
        echo "<script>window.location.href='thought.php';</script>";
    }

    $req = "SELECT * FROM `thought` WHERE user_id='$id'";
    $re = mysqli_query($con, $req);
    if ((mysqli_num_rows($re) > 0)) {
        while (($row = mysqli_fetch_assoc($re))) {
            $th = $row;
        }
    }
    $num3 = mysqli_num_rows($re);

    if (isset($_POST['all'])) {
        echo "<script>window.location.href='all_thoughts.php';</script>";
    }
    if (isset($_POST['post'])) {
        echo "<script>window.location.href='addpost.php';</script>";
    }
    if (isset($_POST['all_post'])) {
        echo "<script>window.location.href='all_post.php';</script>";
    }

    $post = "SELECT * FROM `post` WHERE user_id='$id'";
    $pic = mysqli_query($con, $post);
    if ((mysqli_num_rows($pic) > 0)) {
        while (($row = mysqli_fetch_assoc($pic))) {
            $pc = $row;
        }
    }
    $pic_cnt = mysqli_num_rows($pic);

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
}
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card-group" style="margin-top: 50px;">
                <div class="card">
                    <div class="alert alert-primary" role="alert">
                        Schoolo !
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <form method="POST" action="" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <?php
                                        if (($final['image']) == "profile/") {
                                        ?>
                                            <center><img src="images/profile.png" class="rounded-circle img-fluid" alt="User Image" width="130" height="130"></center>
                                        <?php
                                        } else if (($final['image']) != null) {
                                        ?>
                                            <center><img src="<?php echo $final['image'] ?>" class="rounded-circle img-fluid" alt="User Image" width="170" height="170"></center>

                                        <?php
                                        } else {
                                        ?>
                                            <center><img src="images/profile.png" class="rounded-circle img-fluid" alt="User Image" width="130" height="130"></center>
                                        <?php
                                        }
                                        ?>
                                        <br>
                                    </div>
                            </div>
                            <div class="col-md-7">
                                <div style="white-space: pre-line;">
                                    <b><?php echo $final['avatar']; ?></b>
                                    <?php echo $final['about']; ?></br><br>
                                </div>
                                <div>
                                    <?php
                                    if ($num1 == null) {
                                    ?>
                                        0 Connections
                                    <?php
                                    } else {
                                    ?>
                                        <b> <?php echo $num1 ?> Connections</b>
                                    <?php
                                    }
                                    ?>
                                </div><br>
                                <input type="submit" class="btn btn-primary" style="background-color:lightgreen" name="post" value="Add Post">
                                <input type="submit" class="btn btn-primary" style="background-color:lightblue" name="thought" value="Share your thoughts...">
                            </div>
                        </div>
                        <hr>
                        <u>
                            <h2 style="font-family:serif;">Info -</h2>
                        </u><br>
                        <?php
                        if ($pic_cnt != null) {
                        ?>

                            <div class="form-group">
                                <label for="thought"><b>Latest Post - </b></label><br>
                                <img src="<?php echo $pc['image'] ?>" height="150" width="240" class="img-fluid"><br><br>

                                <?php
                                $timestamp = $pc['image_timestamp'];
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

                                <?php
                                if ($_SESSION['like_from'] == false) {
                                    $_SESSION['like_tp'] = $timestamp;
                                ?>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <button class="btn btn-primary" style="background-color: blue; color:white;" value="<?php echo $pc['image_timestamp']; ?>" type="submit" name="like"><i class="fa fa-thumbs-up" aria-hidden="true"></i></button></div><br><br>
                                        <?php $_SESSION['like_tp'] = $timestamp; ?>
                                        <div class="col-md-3"><a href="likes_from.php"><?php echo $cnt; ?> Likes</a><br><br></div>
                                        <div class="col-md-8"></div>
                                    </div>
                                <?php
                                } else {
                                    $_SESSION['like_tp'] = $timestamp;
                                ?>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <button class="btn btn-primary" value="<?php echo $pc['image_timestamp']; ?>" type="submit" name="dislike"><i class="fa fa-thumbs-up" aria-hidden="true"></i></button></div><br><br>
                                        <?php $_SESSION['like_tp'] = $timestamp; ?>
                                        <div class="col-md-3"><a href="likes_from.php"><?php echo $cnt; ?> Likes</a><br><br></div>
                                        <div class="col-md-8"></div>
                                    </div>
                                <?php
                                }
                                ?>

                                <u> <b>Caption</b></u> -<br> <?php echo $pc['caption']; ?><br><br>
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
                                <button class="btn btn-primary" style="background-color: white; color:gray" name="all_post">All Posts..<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button><br><br>
                                <hr>
                            </div>
                        <?php
                        }
                        ?>
                        <?php
                        if ($num3 != null) {
                        ?>

                            <div class="form-group">
                                <label for="thought"><b>Latest expressed Thoughts - </b></label><br>
                                <b>Mood</b> -<br> <?php echo $th['mood']; ?><br><br>
                                <b>Thoughts</b> -<br> <?php echo $th['thoughts']; ?><br><br>
                                <?php
                                $timestamp = $th['timestamp'];
                                $datetimeFormat = 'Y-m-d H:i';

                                $date = new \DateTime();
                                $date->setTimestamp($timestamp + '19800');
                                ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <small><b>Shared on</b> -<br> <?php echo $date->format($datetimeFormat); ?><br><br></small>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary" name="del_th" style="background-color: lightcoral;" value="<?php echo $timestamp; ?>">Delete this thought</button>
                                    </div><br><br>
                                    <button class="btn btn-primary" style="background-color: white; color:gray" name="all">See More Expressed thoughts <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button>
                                    <hr>
                                </div>
                            </div>
                        <?php
                        }
                        ?><br>
                        <div class="form-group">
                            <label for="dob"><b>Date of Birth - </b></label><br>
                            <?php echo $final['dob']; ?>
                        </div>
                        <hr>
                        <label for="education"><b>Education :</b></label>
                        <?php

                        if ($num == null) {
                        ?>
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
                        <hr>
                <?php
                            }
                        }
                ?>
                <div class="form-group">
                    <label for="skill"><b>Skills/Passion :</b></label>
                    <textarea name="skills" class="form-control" style="background-color:white;" readonly><?php echo $final['skills']; ?></textarea>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



<?php
include('footer.php');
?>