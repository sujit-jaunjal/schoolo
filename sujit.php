<?php

include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $_SESSION['post'] = null;
    $_SESSION['feed'] = null;
    $_SESSION['like_from'] = false;
    $search = $_SESSION['search'];
    $_SESSION['search_conn'] = null;

    $email = $_SESSION['email'];

    $query = "SELECT *FROM `registration` WHERE email='sujitjaunjal4801@gmail.com'";

    $res = mysqli_query($con, $query);

    if ((mysqli_num_rows($res) > 0)) {
        while (($row = mysqli_fetch_assoc($res))) {
            $final = $row;
        }
    }
    $run = "SELECT *FROM `registration` WHERE email='$email'";

    $result = mysqli_query($con, $run);

    if ((mysqli_num_rows($result) > 0)) {
        while (($row = mysqli_fetch_assoc($result))) {
            $find = $row;
        }
    }
    $user_id = $find['id'];
    $connections = $final['id'];
    $avatar = $final['avatar'];
    $find_mail = $final['email'];

    $request_from = $find['avatar'];
    $request_to = $final['avatar'];

    if (isset($_POST['connect'])) {

        $add = "INSERT INTO `connections`(user_id, my_connections, request_from, request_to) VALUES('$user_id', null, '$request_from', '$request_to');";
        mysqli_query($con, $add);
    }

    if (isset($_POST['disconnect'])) {

        $disconnect = "DELETE FROM `connections` WHERE (user_id='$connections' AND my_connections='$user_id') OR (user_id='$user_id' AND my_connections='$connections') OR (user_id='$user_id' AND request_to='$avatar')";
        mysqli_query($con, $disconnect);
    }

    $connect = "SELECT * FROM `connections` WHERE (user_id='$user_id' AND my_connections='$connections') OR (user_id='$connections' AND my_connections='$user_id')";

    $show = mysqli_query($con, $connect);
    $num = mysqli_num_rows($show);

    $connect1 = "SELECT * FROM `connections` WHERE user_id='$user_id' AND request_to='$avatar'";

    $show1 = mysqli_query($con, $connect1);
    $num1 = mysqli_num_rows($show1);


    if (isset($_POST['msg'])) {
        echo "<script>window.location.href='send_msg.php';</script>";
    }
    $edu = "SELECT * FROM `education` WHERE email='$find_mail'";
    $val = mysqli_query($con, $edu);
    $num4 = mysqli_num_rows($val);

    $request = "SELECT distinct(user_id) FROM `connections` where my_connections='$connections'
    UNION
    SELECT distinct(my_connections) FROM `connections` where user_id='$connections'";
    $res1 = mysqli_query($con, $request);
    $num2 = mysqli_num_rows($res1);

    $post = "SELECT * FROM `post` WHERE user_id='$connections'";
    $pic = mysqli_query($con, $post);
    if ((mysqli_num_rows($pic) > 0)) {
        while (($row = mysqli_fetch_assoc($pic))) {
            $pc = $row;
        }
    }
    $pic_cnt = mysqli_num_rows($pic);

    $req = "SELECT * FROM `thought` WHERE user_id='$connections'";
    $re = mysqli_query($con, $req);
    if ((mysqli_num_rows($re) > 0)) {
        while (($row = mysqli_fetch_assoc($re))) {
            $th = $row;
        }
    }
    $num3 = mysqli_num_rows($re);

    if (isset($_POST['all'])) {
        $all = $_POST['all'];
        $_SESSION['feed'] = $all;
        echo "<script>window.location.href='search_feed.php';</script>";
    }

    if (isset($_POST['all_post'])) {
        $all_post = $_POST['all_post'];
        $_SESSION['post'] = $all_post;
        echo "<script>window.location.href='search_post.php';</script>";
    }
    if (isset($_POST['like'])) {
        $pic_time = $_POST['like'];
        $like = "INSERT INTO post(user_id, image, caption, image_timestamp, like_from) VALUES('','','','$pic_time', '$request_from')";
        mysqli_query($con, $like);
    }

    if (isset($_POST['dislike'])) {
        $pic_time = $_POST['dislike'];

        $dislike = "DELETE FROM post WHERE image_timestamp='$pic_time' AND like_from='$request_from'";
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
                                            <center><img src="<?php echo $final['image'] ?>" class="rounded-circle img-fluid" alt="User Image" width="130" height="130"></center>

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
                                    if ($num2 == null) {
                                    ?>
                                        0 Connections
                                    <?php
                                    } else {
                                        $_SESSION['search_conn'] = $avatar;
                                    ?>
                                        <a href="search_conn.php" type="submit"><b> <?php echo $num2 ?> Connections</b></a>
                                    <?php
                                    }
                                    ?>
                                </div><br>
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
                                        if ($request_from == $fnd_pic['like_from']) {
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
                                        <div class="col-md-3"><a href="likes_from.php"><?php echo $cnt; ?> Likes</a><br></div>
                                        <div class="col-md-8"></div>
                                    </div>
                                <?php
                                } else {
                                    $_SESSION['like_tp'] = $timestamp;
                                ?>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <button class="btn btn-primary" value="<?php echo $pc['image_timestamp']; ?>" type="submit" name="dislike"><i class="fa fa-thumbs-up" aria-hidden="true"></i></button></div><br><br>
                                        <div class="col-md-3"><a href="likes_from.php"><?php echo $cnt; ?> Likes</a><br></div>
                                        <div class="col-md-8"></div>
                                    </div>
                                <?php
                                }
                                ?>
                                <hr>
                                <u> <b>Caption</b></u> -<br> <?php echo $pc['caption']; ?><br><br>
                                <?php
                                $datetimeFormat = 'Y-m-d H:i';

                                $date = new \DateTime();
                                $date->setTimestamp($timestamp + '19800');
                                ?>
                                <small><b>Posted on</b> -<br> <?php echo $date->format($datetimeFormat); ?><br><br></small>

                                <button class="btn btn-primary" style="background-color: white; color:gray" value="<?php echo $pc['user_id']; ?>" name="all_post">All Posts..<i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button><br><br>
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
                                <small><b>Shared on</b> -<br> <?php echo $date->format($datetimeFormat); ?><br><br></small>
                                <button class="btn btn-primary" style="background-color: white; color:gray" value="<?php echo $th['user_id']; ?>" name="all">See More Expressed thoughts <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button>
                                <hr>
                            </div>

                        <?php
                        }
                        ?><br>

                        <div class="form-group">
                            <label for="dob"><b>Date of Birth - </b></label><br>
                            <?php echo $final['dob']; ?>
                        </div>
                        <label for="education"><b>Education :</b></label>
                        <?php

                        if ($num4 == null) {
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
    <div class="col-md-2">
    </div>
</div>
</div>
</div>
<?php

include('footer.php');

?>