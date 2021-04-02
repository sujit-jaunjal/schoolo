<?php
include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $email = $_SESSION['email'];

    if (isset($_POST['withdraw'])) {

        $user = $_POST['withdraw'];

        $query2 = "DELETE FROM `connections` WHERE request_to='$user'";
        mysqli_query($con, $query2);
    }

    $run = "SELECT * FROM `registration` WHERE email='$email'";

    $result = mysqli_query($con, $run);

    if ((mysqli_num_rows($result) > 0)) {
        while (($row = mysqli_fetch_assoc($result))) {
            $final = $row;
        }
    }

    $from = $final['avatar'];
    $request = "SELECT distinct(request_to) FROM `connections` WHERE request_from='$from' ORDER BY id DESC";
    $res = mysqli_query($con, $request);
    $num = mysqli_num_rows($res);
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
                        <h2 style="font-family:serif;">My Requests -</h2>
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
                                                $avatar = $row['request_to'];
                                                $search = "SELECT * FROM `registration` WHERE avatar='$avatar'";
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
                                                <button class="btn btn-primary" type="submit" value="<?php echo $find['avatar']; ?>" name="withdraw">Withdraw Request</button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </form>
                            <?php
                            }
                        } else {
                            ?>
                            <h4>No Requests !</h4>
                        <?php
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