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
    $avatar = $final['anonymous_id'];


    $fetch = "SELECT distinct(user2) FROM `messages` where user1='$avatar' AND anonymous='1'";
    $result = mysqli_query($con, $fetch);
    $num = mysqli_num_rows($result);
    if (isset($_POST['user'])) {

        $user = $_POST['user'];
        $_SESSION['user'] = $user;
        echo "<script>window.location.href='personal_unknown.php';</script>";
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
                                <?php include('profile_icon.php'); ?><button type="submit" class="btn btn-primary" name="change" onclick="fun1()"><?php echo $final['avatar']; ?></button>
                            </div>
                            <div class="col-md-6">
                                <img src="images/anonymous.png" class="rounded-circle" alt="User Image" width="50" height="50"><button type="submit" onclick="fun()" class="btn btn-primary" name="change">Anonymous</button>
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
                                        $avatar = $row['user2'];
                                        $search = "SELECT * FROM `registration` WHERE avatar='$avatar' OR anonymous_id='$avatar'";
                                        $do = mysqli_query($con, $search);
                                        if ((mysqli_num_rows($do) > 0)) {
                                            while (($row = mysqli_fetch_assoc($do))) {
                                                $find = $row;
                                            }
                                        }
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
                                                $read = "SELECT read_user FROM messages WHERE read_user='0' AND anonymous='1' AND user1='$av'";
                                                $rs = mysqli_query($con, $read);
                                                $read_num = mysqli_num_rows($rs);
                                                if ($read_num != 0) {
                                                ?>
                                                    <?php echo $read_num; ?> new messages !
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </form>
                            <?php
                            }
                        } else {
                            ?>
                            <h3>No Messages ! </h3><a href="anonymous.php">
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