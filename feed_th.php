<?php
include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $email = $_SESSION['email'];

    $que = "SELECT * FROM `registration` WHERE email='$email'";
    $res = mysqli_query($con, $que);

    if ((mysqli_num_rows($res) > 0)) {
        while (($row = mysqli_fetch_assoc($res))) {
            $final = $row;
        }
    }
    $id = $final['id'];

    $request = "SELECT distinct(user_id) FROM `connections` where (my_connections='$id' AND user_id IS NOT NULL) UNION SELECT distinct(my_connections) FROM `connections` where (user_id='$id' AND my_connections IS NOT NULL)";
    $res = mysqli_query($con, $request);
    $num = mysqli_num_rows($res);
    $all = array();

    if (isset($_POST['feed_post'])) {
        echo "<script>window.location.href='feed.php';</script>";
    }
}

?>


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
                                <h2 style="font-family:serif;">My Feed - Thoughts</h2>
                            </div>
                            <div class="col-md-2">
                                <form method="post">
                                    <button class="btn btn-primary" name="feed_post">See Posts</button>
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

                                $check = "SELECT * FROM `thought` WHERE user_id='$user_id' ORDER BY timestamp DESC";
                                $run_check = mysqli_query($con, $check);
                                if ((mysqli_num_rows($run_check) > 0)) {
                                    while (($row = mysqli_fetch_assoc($run_check))) {
                                        $check_res = $row;

                                        array_push($all, [
                                            'avatar' => $curr_user['avatar'],
                                            'mood' => $check_res['mood'],
                                            'thoughts' => $check_res['thoughts'],
                                            'timestamp' => $check_res['timestamp']
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
                                <div class="form-group" id="th">
                                    <label for="thought"><b>Expressed Thoughts - </b></label><br>
                                    <b>Mood</b> -<br> <?php echo $all[$cnt]['mood']; ?><br>
                                    <b>Thoughts</b> -<br> <?php echo $all[$cnt]['thoughts']; ?><br><br>
                                    <?php
                                    $timestamp = $all[$cnt]['timestamp'];
                                    $datetimeFormat = 'Y-m-d H:i';

                                    $date = new \DateTime();
                                    $date->setTimestamp($timestamp + '19800');
                                    ?>
                                    <small><b>Posted on</b> -<br> <?php echo $date->format($datetimeFormat); ?></small><br><br>

                                </div>
                                <hr>
                            </div>
                        <?php
                            $cnt++;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<?php

include('footer.php');
?>