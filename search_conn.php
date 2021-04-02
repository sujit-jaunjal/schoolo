<?php
include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $avatar = $_SESSION['search_conn'];
    $_SESSION['search'] = false;
    $run = "SELECT * FROM `registration` WHERE avatar='$avatar'";

    $result = mysqli_query($con, $run);

    if ((mysqli_num_rows($result) > 0)) {
        while (($row = mysqli_fetch_assoc($result))) {
            $final = $row;
        }
    }
    $id = $final['id'];
    $name = $final['name'];
    $ava = $final['avatar'];

    $request = "SELECT distinct(user_id) FROM `connections` where (my_connections='$id' AND user_id IS NOT NULL) UNION SELECT distinct(my_connections) FROM `connections` where (user_id='$id' AND my_connections IS NOT NULL)";
    $res = mysqli_query($con, $request);
    $num = mysqli_num_rows($res);

    if (isset($_POST['user'])) {
        $view = $_POST['user'];
        $_SESSION['search'] = $view;
        if ($view == $ava) {

            echo "<script>window.location.href='search_profile.php';</script>";
        } else {
            echo "<script>window.location.href='myprofile.php';</script>";
        }
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
                        <h2 style="font-family:serif;"><?php echo $name; ?>'s Connections -</h2>
                    </div>
                    <div class="card-body" style="overflow-y:scroll;">
                        <?php
                        if ($num != null) {
                            while (($row = mysqli_fetch_assoc($res))) {
                        ?>
                                <form method="POST">
                                    <div class="msg">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php
                                                $id = $row['user_id'];
                                                $search = "SELECT * FROM `registration` WHERE id='$id'";
                                                $do = mysqli_query($con, $search);
                                                while (($row = mysqli_fetch_assoc($do))) {
                                                    $find = $row;
                                                }
                                                ?>
                                                <?php include('search_icon.php'); ?>
                                                <input type="submit" style="border: none; background-color:white;" value="<?php echo $find['avatar']; ?>" name="user">
                                                <small>(<?php echo $find['name'] ?>)</small>
                                            </div>
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3">

                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </form>
                            <?php
                            }
                        } else {
                            ?>
                            <h4>No Connections !</h4>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function fun() {
        window.location.href = "search_profile.php";
    }
</script>

<?php
include('footer.php');
?>