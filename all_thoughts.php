<?php

include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    if (isset($_POST['del_th'])) {
        $del_th = $_POST['del_th'];
        $del_tho = "DELETE FROM thought WHERE timestamp='$del_th'";
        mysqli_query($con, $del_tho);
    }

    $email = $_SESSION['email'];

    $query = "SELECT *FROM `registration` WHERE email='$email'";

    $res = mysqli_query($con, $query);

    if ((mysqli_num_rows($res) > 0)) {
        while (($row = mysqli_fetch_assoc($res))) {
            $final = $row;
        }
    }

    $id = $final['id'];

    $req = "SELECT * FROM `thought` WHERE user_id='$id' ORDER BY id DESC";
    $re = mysqli_query($con, $req);
    $num = mysqli_num_rows($re);
}
?>
<style>
    #th {
        border: 1px solid lightblue;
    }
</style>

<div class="container-fluid" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card-group">
                <div class="card">
                    <div class="alert alert-primary" role="alert">
                        <h2 style="font-family:serif;">Your shared thoughts -</h2>
                    </div>
                    <div class="card-body" style="overflow-y:scroll;">
                        <?php
                        if ($num != null) {
                            while (($row = mysqli_fetch_assoc($re))) {
                        ?>
                                <div class="form-group" id="th">
                                    <label for="thought"><b>Expressed Thoughts - </b></label><br>
                                    <b>Mood</b> -<br> <?php echo $row['mood']; ?><br>
                                    <b>Thoughts</b> -<br> <?php echo $row['thoughts']; ?><br>
                                    <?php
                                    $timestamp = $row['timestamp'];
                                    $datetimeFormat = 'Y-m-d H:i';

                                    $date = new \DateTime();
                                    $date->setTimestamp($timestamp + '19800');
                                    ?><br>
                                    <hr>
                                    <form method="POST">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <small><b>Shared on</b> -<br> <?php echo $date->format($datetimeFormat); ?><br><br></small>
                                            </div>
                                            <div class="col-md-6"></div>
                                            <div class="col-md-3">
                                                <button class="btn btn-primary" name="del_th" style="background-color: lightcoral;" value="<?php echo $timestamp; ?>">Delete this thought</button>
                                            </div><br><br>
                                            <hr>
                                        </div>
                                    </form>
                            <?php
                            }
                        }
                            ?>
                                </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include('footer.php');
        ?>