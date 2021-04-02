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
    $avatar1 = $final['avatar'];

    $fetch = "SELECT distinct(id2) FROM `messages` where user1='$avatar1'
    UNION
    SELECT distinct(id1) FROM `messages` where user2='$avatar1'";
    $result = mysqli_query($con, $fetch);
    $num = mysqli_num_rows($result);


    if (isset($_POST['user'])) {

        $user = $_POST['user'];
        $_SESSION['user'] = $user;
        echo "<script>window.location.href='all_personal.php';</script>";
    }

    if (isset($_POST['unknown'])) {

        echo "<script>window.location.href='all_unknown.php';</script>";
    }
    if (isset($_POST['uk'])) {

        $user = $_POST['uk'];
        $_SESSION['user'] = $user;
        echo "<script>window.location.href='recieved_unknown.php';</script>";
    }
}

?>

<script>
    function fun() {
        window.location.href = 'all_unknown.php';
    }

    function fun1() {
        window.location.href = 'all_msgs.php';
    }
</script>

<meta http-equiv="refresh" content="20">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8" style="margin-top: 50px;">
            <div class="card-group">
                <div class="card" style="height: 550px;">
                    <div class="alert alert-primary" role="alert">
                        <div class="row">
                            <div class="col-md-6">
                                <?php include('profile_icon.php'); ?><button type="submit" class="btn btn-primary" name="my" onclick="fun1()"><?php echo $final['avatar']; ?></button>
                            </div>
                            <div class="col-md-6">
                                <img src="images/anonymous.png" class="rounded-circle" alt="User Image" width="50" height="50"><button type="submit" class="btn btn-primary" name="unknown" onclick="fun()">Anonymous</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="overflow-y:scroll;">
                        <?php
                        if ($num != null) {
                            while (($row = mysqli_fetch_assoc($result))) {

                        ?>
                                <form method="POST">
                                    <div class="msg">
                                        <?php
                                        $avatar = $row['id2'];
                                        $search = "SELECT * FROM `registration` WHERE id ='$avatar'";
                                        $do = mysqli_query($con, $search);

                                        if ((mysqli_num_rows($do) > 0)) {
                                            while (($row = mysqli_fetch_assoc($do))) {
                                                $find = $row;
                                            }
                                            $id1 = $find['id'];
                                            $avatar_uk = $find['anonymous_id'];
                                            $avatar2 = $find['avatar'];
                                            $anonymous_user = $find['anonymous_id'];
                                            $uk = "SELECT * FROM `messages` WHERE user1='$anonymous_user' AND id1='$id1' AND anonymous='1'";
                                            $rk = mysqli_query($con, $uk);

                                            $count = mysqli_num_rows($rk);

                                            $uk1 = "SELECT * FROM `messages` WHERE user2='$avatar1' AND user1='$avatar2' AND anonymous IS null";
                                            $rk1 = mysqli_query($con, $uk1);
                                            $count1 = mysqli_num_rows($rk1);
                                            $uk2 = "SELECT * FROM `messages` WHERE user1='$avatar1'  AND user2='$avatar2' AND anonymous IS null";
                                            $rk2 = mysqli_query($con, $uk2);
                                            $count2 = mysqli_num_rows($rk2);
                                        }
                                        if ($count != null) {
                                        ?>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <img src="images/anonymous.png" class="rounded-circle" alt="User Image" width="50" height="50">
                                                    <input type="submit" style="border: none; background-color:white;" value="Anonymous">
                                                    <input type="hidden" value="<?php echo $find['avatar']; ?>" name="uk">
                                                </div>
                                                <div class="col-md-4">
                                                    <?php
                                                    $av = $find['anonymous_id'];
                                                    $read = "SELECT read_user FROM messages WHERE read_user='0' AND anonymous='1' AND user1='$av'";
                                                    $rs1 = mysqli_query($con, $read);
                                                    $read_num = mysqli_num_rows($rs1);
                                                    if ($read_num != 0) {
                                                    ?>
                                                        <?php echo $read_num; ?> new messages !
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <hr>
                                        <?php
                                        }
                                        if ($count2 != null || $count1 != null) {
                                        ?>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <?php include('search_icon.php'); ?>
                                                    <input type="submit" style="border: none; background-color:white;" value="<?php echo $find['avatar']; ?>" name="user">
                                                    <small><?php echo $find['name']; ?></small>
                                                </div>
                                                <div class="col-md-4">
                                                    <?php
                                                    $av = $find['avatar'];
                                                    $read = "SELECT read_user FROM messages WHERE read_user='0' AND anonymous IS NULL AND user1='$av'";
                                                    $rs = mysqli_query($con, $read);
                                                    $read_num = mysqli_num_rows($rs);
                                                    if ($read_num != 0) {
                                                    ?>
                                                        <?php echo $read_num; ?> new messages !
                                                    <?php
                                                    }
                                                    ?>
                                                <?php
                                            }
                                                ?>
                                                </div>
                                                <hr>
                                            </div>
                                </form>
                            <?php
                            }
                        } else {
                            ?>
                            <h3>No Messages ! </h3><a href="user_msg.php">
                                <h5> Start texting now !<h5>
                            </a>
                        <?php
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