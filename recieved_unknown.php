<?php

include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {
    $num1 = null;
    $user = $_SESSION['user'];
    $email = $_SESSION['email'];
    $query = "SELECT * FROM `registration` WHERE avatar='$user'";

    $res = mysqli_query($con, $query);

    if ((mysqli_num_rows($res) > 0)) {
        while (($row = mysqli_fetch_assoc($res))) {
            $find = $row;
        }
    }
    $que = "SELECT * FROM `registration` WHERE email='$email'";
    $user = mysqli_query($con, $que);

    if ((mysqli_num_rows($user) > 0)) {
        while (($row = mysqli_fetch_assoc($user))) {
            $final = $row;
        }
    }

    $id1 = $final['id'];
    $id2 = $find['id'];
    $id2 = $find['id'];
    $user1 = $final['avatar'];
    $user2 = $find['avatar'];
    $user2_uk = $find['anonymous_id'];

    $read = "UPDATE messages SET read_user='1' WHERE id2 = '$id1' AND id1='$id2' AND anonymous='1'";
    $do = mysqli_query($con, $read);



    if (isset($_POST['submit'])) {

        $text = $_POST['text'];
        $timestamp = time();
        if ($text != null) {
            $msg = "INSERT INTO `messages`(id1, id2, user1, user2,anonymous, u_message, msg_time, read_user) VALUES('$id1', '$id2', '$user1', '$user2_uk','1', '$text', '$timestamp','');";

            mysqli_query($con, $msg);
        }
    }
    $check = "SELECT * FROM `messages` WHERE user1='$user2_uk' AND user2='$user1' AND anonymous='1'";
    $show = mysqli_query($con, $check);
    $num = mysqli_num_rows($show);
    if ($num != null) {
        $done = "SELECT * FROM `messages` WHERE (user1='$user1' AND user2='$user2_uk' AND anonymous='1') OR (user1='$user2_uk' AND user2='$user1' AND anonymous='1')";
        $right = mysqli_query($con, $done);
        $num1 = mysqli_num_rows($right);
    }
}
?>

<style>
    textarea {
        width: 100%;
    }
</style>

<meta http-equiv="refresh" content="30">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6" style="margin-top: 50px;">
            <div class="card-group">
                <div class="card" style="height: 550px;">
                    <div class="alert alert-primary" role="alert">
                        <img src="images/anonymous.png" class="rounded-circle" alt="User Image" width="50" height="50"><b>Anonymous</b>
                    </div>
                    <div id="messageBody" class="card-body" style="overflow-y:scroll;">
                        <?php
                        if ($num1 != null) {
                            while (($row = mysqli_fetch_assoc($right))) {
                        ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <?php
                                        if ($row['id1'] == $id2) {
                                        ?>
                                            <div class="msg " style="white-space: pre-line;">
                                                <small><b>anonymous</b></small>
                                                <?php echo $row['u_message']; ?>
                                                <?php
                                                $timestamp = $row['msg_time'];
                                                $datetimeFormat = 'H:i';

                                                $date = new \DateTime();
                                                $date->setTimestamp($timestamp + '19800');
                                                ?>
                                                <small><br><b><?php echo $date->format($datetimeFormat); ?></b></small>
                                            </div>




                                        <?php
                                        } ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        if ($row['id1'] == $id1) {
                                        ?>
                                            <div class="you text-right" style="white-space: pre-line;">
                                                <small><b>You</b></small>
                                                <?php echo $row['u_message']; ?>
                                                <?php
                                                $timestamp = $row['msg_time'];
                                                $datetimeFormat = 'H:i';

                                                $date = new \DateTime();
                                                $date->setTimestamp($timestamp + '19800');
                                                ?>
                                                <small><br><b><?php echo $date->format($datetimeFormat); ?></b></small>
                                            </div>

                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>

                    </div>
                    <div class="card-footer" style="background-color: white;">
                        <div class="row">
                            <div class="col-md-11">
                                <form method="POST">

                                    <textarea class="form-control" name="text" placeholder="Enter text..."></textarea>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-primary " name="submit" type="submit" style="margin-top: 10px;"><i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>