<?php
include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $email = $_SESSION['email'];
    $_SESSION['like_from'] = false;
    $_SESSION['guide'] = false;

    $que = "SELECT * FROM `registration` WHERE email='$email'";
    $res = mysqli_query($con, $que);

    if ((mysqli_num_rows($res) > 0)) {
        while (($row = mysqli_fetch_assoc($res))) {
            $final = $row;
        }
    }
    $id = $final['id'];
    $like_avatar = $final['avatar'];

    $request = "SELECT distinct(user_id) FROM `connections` where (my_connections='$id' AND user_id IS NOT NULL) UNION SELECT distinct(my_connections) FROM `connections` where (user_id='$id' AND my_connections IS NOT NULL)";
    $res = mysqli_query($con, $request);
    $num = mysqli_num_rows($res);
    $all = array();

    if (isset($_POST['feed_th'])) {
        echo "<script>window.location.href='feed_th.php';</script>";
    }

    if (isset($_POST['view'])) {
        $sugg = $_POST['view'];
        $_SESSION['search'] = $sugg;
        $_SESSION['unknown'] = false;
        echo "<script>window.location.href='search_profile.php';</script>";
    }
    if (isset($_POST['like'])) {
        $pic_time = $_POST['like'];
        $like = "INSERT INTO post(user_id, image, caption, image_timestamp, like_from) VALUES('','','','$pic_time', '$like_avatar')";
        mysqli_query($con, $like);
    }

    if (isset($_POST['dislike'])) {
        $pic_time = $_POST['dislike'];

        $dislike = "DELETE FROM post WHERE image_timestamp='$pic_time' AND like_from='$like_avatar'";
        mysqli_query($con, $dislike);
    }
}

?>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<div class="container-fluid" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card-group">
                <div class="card">
                    <div class="alert alert-primary" role="alert">
                        <div class="row">
                            <div class="col-md-10">
                                <h2 style="font-family:serif;">My Feed - Posts</h2>
                            </div>
                            <div class="col-md-2">
                                <form method="POST">
                                    <button class="btn btn-primary" name="feed_th">See Thoughts</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="overflow-y:scroll;">
                        <?php
                        if ($num != null) {
                            while (($row = mysqli_fetch_assoc($res))) {

                                $user_id = $row['user_id'];
                                $user = "SELECT * FROM `registration` WHERE id='$user_id'";
                                $run_user = mysqli_query($con, $user);

                                if ((mysqli_num_rows($run_user) > 0)) {
                                    while (($row = mysqli_fetch_assoc($run_user))) {
                                        $curr_user = $row;
                                    }
                                }

                                $check = "SELECT * FROM `post` WHERE user_id='$user_id' ORDER BY image_timestamp DESC";
                                $run_check = mysqli_query($con, $check);
                                if ((mysqli_num_rows($run_check) > 0)) {
                                    while (($row = mysqli_fetch_assoc($run_check))) {
                                        $check_res = $row;

                                        array_push($all, [
                                            'avatar' => $curr_user['avatar'],
                                            'image' => $check_res['image'],
                                            'caption' => $check_res['caption'],
                                            'timestamp' => $check_res['image_timestamp']
                                        ]);
                        ?>

                                <?php
                                    }
                                } else {
                                    $check_res = null;
                                }
                                ?>
                            <?php
                            }
                        } else {
                            ?>
                            <h4>No feed...try to add connections !</h4>
                        <?php
                        }
                        ?>
                        <?php
                        usort($all, function ($a, $b) {
                            return $b['timestamp'] <=> $a['timestamp'];
                        });
                        $val = count($all);
                        $cnt = 0;
                        while ($cnt < $val) {

                            $av = $all[$cnt]['avatar'];;
                            $pro = "SELECT image FROM `registration` where avatar='$av'";
                            $profile = mysqli_query($con, $pro);
                            if ((mysqli_num_rows($profile) > 0)) {
                                while (($row = mysqli_fetch_assoc($profile))) {
                                    $curr_user = $row;
                                }
                            }
                        ?>
                            <div class="form-group">
                                <hr>
                                <?php include('feed_icon.php'); ?> <?php echo $all[$cnt]['avatar']; ?><br><br>
                                <hr>
                                <center><img src="<?php echo $all[$cnt]['image'] ?>" height="150" width="240" class="img-fluid"></center><br><br>

                                <?php
                                $timestamp = $all[$cnt]['timestamp'];
                                $cap = $all[$cnt]['caption'];
                                $find = "SELECT distinct(like_from) FROM post where image_timestamp='$timestamp' AND like_from!='0'";
                                $fnd = mysqli_query($con, $find);
                                $cnt = mysqli_num_rows($fnd);
                                if ((mysqli_num_rows($fnd) > 0)) {
                                    while (($row = mysqli_fetch_assoc($fnd))) {
                                        $fnd_pic = $row;
                                        if ($like_avatar == $fnd_pic['like_from']) {
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
                                                <button class="btn btn-primary" style="background-color: blue; color:white;" value="<?php echo $timestamp; ?>" type="submit" name="like"><i class="fa fa-thumbs-up" aria-hidden="true"></i></button></div><br><br>
                                            <div class="col-md-3">
                                                <a href="likes_from.php"><?php echo $cnt; ?> Likes</a><br>
                                            </div>
                                            <div class="col-md-8"></div>
                                        </div>
                                    <?php
                                    } else {
                                        $_SESSION['like_tp'] = $timestamp;
                                    ?>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <button class="btn btn-primary" value="<?php echo $timestamp; ?>" type="submit" name="dislike"><i class="fa fa-thumbs-up" aria-hidden="true"></i></button></div><br><br>
                                            <div class="col-md-3"> <a href="likes_from.php"><?php echo $cnt; ?> Likes</a><br></div>
                                            <div class="col-md-8"></div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </form>
                                <hr>
                                <u> <b>Caption</b></u> -<br> <?php echo $cap; ?><br><br>
                                <?php
                                $datetimeFormat = 'Y-m-d H:i';

                                $date = new \DateTime();
                                $date->setTimestamp($timestamp + '19800');
                                ?>
                                <small><b>Posted on</b> -<br> <?php echo $date->format($datetimeFormat); ?></small><br><br>
                                <hr>
                            </div>
                        <?php
                            $cnt++;
                        }
                        ?>
                        <?php
                        $arr = array();
                        $search = "SELECT * FROM registration WHERE id!='$id' ORDER BY id DESC";
                        $explore = mysqli_query($con, $search);
                        $xt = mysqli_num_rows($explore);
                        $xr = 0;
                        if (($xt > 0)) {
                            while ($xr < $xt) {
                                $row = mysqli_fetch_assoc($explore);

                                $suggest = $row['id'];

                                $search2 = "SELECT * FROM connections WHERE (user_id='$id' AND my_connections='$suggest') OR (user_id='$suggest' AND my_connections='$id')";
                                $explore2 = mysqli_query($con, $search2);
                                if ((mysqli_num_rows($explore2) == null)) {
                                    array_push($arr, $row);
                                }
                                $xr++;
                            }
                        }
                        $cnt_arr = count($arr);
                        $ctr = 0;
                        ?>
                        <hr>
                        <br><br>
                        <div class="container">
                            <form method="post">
                                <div class="row">
                                    <?php
                                    if (count($arr) > 0) {
                                        while ($ctr < $cnt_arr) {
                                    ?>
                                            <div class="col-md-4">
                                                <div class="card-group">
                                                    <div class="card">
                                                        <div class="alert alert-primary" role="alert">
                                                            <center>
                                                                <h5 style="font-family:serif;">Suggestions</h5>
                                                            </center>
                                                        </div>
                                                        <center><?php include('suggest_icon.php'); ?></center>
                                                        <center><small><?php echo $arr[$ctr]['avatar']; ?></small></center>
                                                        <center><?php echo $arr[$ctr]['name']; ?></center><br>
                                                        <button type="submit" class="btn btn-primary" name="view" value="<?php echo $arr[$ctr]['avatar']; ?>">View Profile</button>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                            $ctr++;
                                            if ($ctr == 3) {
                                                break;
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>

        <?php
        include('footer.php');
        ?>