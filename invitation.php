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

    if (isset($_POST['add'])) {

        $user = $_POST['add'];

        $query1 = "UPDATE `connections` SET my_connections='$id', request_to=null, request_from=null WHERE request_from='$user'";
        mysqli_query($con, $query1);
    }

    if (isset($_POST['decline'])) {

        $id = $_POST['id'];
        $user = $_POST['decline'];

        $query2 = "DELETE FROM `connections` WHERE request_from='$user'";
        mysqli_query($con, $query2);
    }

    $to = $final['avatar'];
    $request = "SELECT distinct(request_from) FROM `connections` WHERE request_to='$to' ORDER BY id DESC";
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
                        <h2 style="font-family:serif;">Invitations -</h2>
                    </div>
                    <div class="card-body" style="overflow-y:scroll;">
                        <?php
                        if ($num != null) {
                            while (($row = mysqli_fetch_assoc($res))) {
                        ?>
                                <form method="POST">
                                    <div class="msg">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <?php
                                                $avatar = $row['request_from'];
                                                $search = "SELECT * FROM `registration` WHERE avatar='$avatar'";
                                                $do = mysqli_query($con, $search);
                                                while (($row = mysqli_fetch_assoc($do))) {
                                                    $find = $row;
                                                }
                                                ?>
                                                <?php include('search_icon.php'); ?>
                                                <input type="submit" style="border: none; background-color:white;" value="<?php echo $find['avatar']; ?>" name="user">
                                                <small>(<?php echo $find['name'] ?>)</small> sent you a connection request.
                                            </div>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-3">
                                                <input type="hidden" value="<?php echo $find['id']; ?>" name="id">
                                                <button class="btn btn-primary" type="submit" value="<?php echo $find['avatar']; ?>" name="decline"><i class="fa fa-times"></i></button>
                                                <button class="btn btn-primary" type="submit" value="<?php echo $find['avatar']; ?>" name="add"><i class="fa fa-check"></i></button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </form>
                            <?php
                            }
                        } else {
                            ?>
                            <h4>No Invitations !</h4>
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