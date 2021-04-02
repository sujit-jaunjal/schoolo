<?php

include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {
    $id = $_SESSION['feed'];

    $query = "SELECT *FROM `registration` WHERE id='$id'";

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
                        <h2 style="font-family:serif;">Shared thoughts -</h2>
                    </div>
                    <div class="card-body" style="overflow-y:scroll;">
                        <?php
                        if ($num != null) {
                            while (($row = mysqli_fetch_assoc($re))) {
                        ?>
                                <div class="form-group" id="th">
                                    <label for="thought"><b>Expressed Thoughts - </b></label><br>
                                    <b>Mood</b> -<br> <?php echo $row['mood']; ?><br>
                                    <b>Thoughts</b> -<br> <?php echo $row['thoughts']; ?><br><br>
                                    <?php
                                    $timestamp = $row['timestamp'];
                                    $datetimeFormat = 'Y-m-d H:i';

                                    $date = new \DateTime();
                                    $date->setTimestamp($timestamp + '19800');
                                    ?>
                                    <small><b>Shared on</b> -<br> <?php echo $date->format($datetimeFormat); ?><br><br></small>

                                    <br><br><br>
                                </div>
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