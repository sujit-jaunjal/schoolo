<?php
include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $email = $_SESSION['email'];

    $run = "SELECT * FROM `registration` WHERE email='$email'";

    $result = mysqli_query($con, $run);

    if ((mysqli_num_rows($result) > 0)) {
        while (($row = mysqli_fetch_assoc($result))) {
            $final = $row;
        }
    }

    $id = $final['id'];

    $to = $final['avatar'];
    $request = "SELECT * FROM `connections` WHERE request_to='$to' ORDER BY id DESC";
    $res = mysqli_query($con, $request);
    $num = mysqli_num_rows($res);

    $conn = "SELECT * FROM `connections` WHERE (user_id='$id' AND my_connections IS NOT NULL) OR (my_connections='$id' AND user_id IS NOT NULL)";
    $con_res = mysqli_query($con, $conn);
    $con_num = mysqli_num_rows($con_res);

    $read = "SELECT * FROM messages WHERE id2='$id' AND read_user='0'";
    $read_res = mysqli_query($con, $read);
    $read_num = mysqli_num_rows($read_res);

    if ($read_num != null) {
        $_SESSION['new_msg'] = true;
    } else {
        $_SESSION['new_msg'] = false;
    }
    if ($num != null) {
        $_SESSION['bday'] = true;
    } else {
        $_SESSION['bday'] = false;
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
                        <h2 style="font-family:serif;">Notifications -</h2>
                    </div>
                    <div class="card-body" style="overflow-y:scroll;">
                        <?php
                        if ($num != null) {
                            while (($row = mysqli_fetch_assoc($res))) {
                        ?>
                                <form method="POST">
                                    <div class="msg">
                                        <div class="row">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <?php
                                                $avatar = $row['request_from'];
                                                $search = "SELECT * FROM `registration` WHERE avatar='$avatar'";
                                                $do = mysqli_query($con, $search);
                                                while (($row = mysqli_fetch_assoc($do))) {
                                                    $find = $row;
                                                }
                                                ?>
                                                You have a New Connection request - <?php include('search_icon.php'); ?>
                                                <input type="submit" style="border: none; background-color:white;" value="<?php echo $find['avatar']; ?>" name="user">
                                                <small>(<?php echo $find['name'] ?>)</small>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <hr>
                                    </div>
                                </form>
                                <?php
                            }
                        }
                        if ($con_num != null) {
                            while (($row = mysqli_fetch_assoc($con_res))) {

                                $con_id = $row['user_id'];
                                $con_id2 = $row['my_connections'];
                                if ($id == $con_id) {
                                    $get = "SELECT * FROM `registration` WHERE id='$con_id2'";
                                } else {
                                    $get = "SELECT * FROM `registration` WHERE id='$con_id'";
                                }
                                $get_res = mysqli_query($con, $get);

                                if ((mysqli_num_rows($get_res) > 0)) {
                                    while (($row = mysqli_fetch_assoc($get_res))) {
                                        $ress = $row;
                                    }
                                }

                                $dob = $ress['dob'];
                                $orderdate = explode('-', $dob);
                                $bdmonth = $orderdate[1];
                                $bdday = $orderdate[2];
                                $today = date('m-d');
                                $comp = explode('-', $today);
                                $day = $comp['1'];
                                $month = $comp['0'];
                                if ($id != $ress['id']) {
                                    if ($bdmonth == $month) {
                                        if ($bdday == $day) {
                                ?>
                                            <center> Hey, its your friend <?php include('bday_icon.php'); ?><?php echo $ress['name'] ?>'s birthday, text him good wishes !</center>
                        <?php
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                        <?php if ($num == null and $con_num == null) {
                        ?>
                            <h4>No Notifications !</h4>
                        <?php
                        }
                        ?>

                        <?php
                        if ($read_num != 0) {
                            while (($row = mysqli_fetch_assoc($read_res))) {
                                if ($row['anonymous'] == 1) {
                        ?>
                                    <div> You have new message from - <img src="images/anonymous.png" class="rounded-circle" alt="User Image" width="50" height="50">
                                        <input type="submit" style="border: none; background-color:white;" value="Anonymous">
                                    </div>
                                    <hr>
                                <?php
                                } else {
                                    $user = $row['user1'];
                                    $not = "SELECT * FROM registration WHERE avatar='$user'";
                                    $noti = mysqli_query($con, $not);
                                    if ((mysqli_num_rows($noti) > 0)) {
                                        while (($row = mysqli_fetch_assoc($noti))) {
                                            $noti_user = $row;
                                        }
                                    }
                                ?>
                                    <div>
                                        You have new message from - <?php
                                                                    if (($noti_user['image']) == "profile/") {
                                                                    ?>
                                            <img src="images/profile.png" class="rounded-circle" alt="User Image" width="50" height="50">
                                        <?php
                                                                    } else if (($noti_user['image']) != null) {
                                        ?>
                                            <img src="<?php echo $noti_user['image'] ?>" class="rounded-circle" alt="User Image" width="50" height="50">

                                        <?php
                                                                    } else {
                                        ?>
                                            <img src="images/profile.png" class="rounded-circle" alt="User Image" width="50" height="50">
                                        <?php
                                                                    }
                                        ?>
                                        <input type="submit" style="border: none; background-color:white;" value="<?php echo $noti_user['avatar']; ?>" name="user">
                                        <small><?php echo $noti_user['name']; ?></small>
                                    </div>
                        <?php
                                }
                            }
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