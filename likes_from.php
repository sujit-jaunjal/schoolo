<?php
include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $likes = $_SESSION['like_tp'];

    $run = "SELECT like_from FROM `post` WHERE image_timestamp='$likes' AND like_from!='0'";
    $result = mysqli_query($con, $run);
    $num = mysqli_num_rows($result);
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
                        <h2 style="font-family:serif;">Likes from -</h2>
                    </div>
                    <div class="card-body" style="overflow-y:scroll;">
                        <?php if ($num != null) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <form method="POST">
                                    <div class="msg">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php
                                                $id = $row['like_from'];
                                                $search = "SELECT * FROM `registration` WHERE avatar='$id'";
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
                            <h4>No Likes Yet !</h4>
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