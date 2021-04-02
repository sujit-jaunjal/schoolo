<?php

include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $_SESSION['unknown'] = false;
    $_SESSION['search'] = false;
    $email = $_SESSION['email'];
    $_SESSION['same'] = false;
    $query = "SELECT * FROM `registration` WHERE email='$email'";
    $out = mysqli_query($con, $query);
    if ((mysqli_num_rows($out) > 0)) {
        while (($row = mysqli_fetch_assoc($out))) {
            $final = $row;
        }
    }
    $av = $final['avatar'];

    if (isset($_POST['submit'])) {

        $avatar = $_POST['avatar_name'];
        $search = "SELECT * FROM `registration` WHERE avatar='$avatar'";
        $res = mysqli_query($con, $search);

        if ((mysqli_num_rows($res) > 0)) {
            while (($row = mysqli_fetch_assoc($res))) {
                $find = $row;
            }
        }

        $av2 = $find['avatar'];
        if ($av2 == $av) {
            $_SESSION['same'] = true;
        }

        if ((mysqli_num_rows($res) == null)) {
            echo "<script>alert('No user found !');</script>";
        } else {
            $_SESSION['search'] = $avatar;
        }
    }
}
?>

<head>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script>
        $(function() {
            $("#avatar_name").autocomplete({
                source: "search.php",
            });
        });
    </script>

</head>

<div class="container-fluid" style="margin-top:50px;">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card-group">
                <div class="card">
                    <div class="alert alert-primary" role="alert">
                        Search Engine
                    </div>
                    <div class="card-body">
                        Start searching Here -
                        </br>
                        <br>
                        <form method="POST">
                            <div class="input-group">
                                <input class="form-control" type="text" id="avatar_name" name="avatar_name" placeholder="Enter avatar...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary" name="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <?php
                        if ($_SESSION['search'] != false) {
                        ?>
                            <script type="text/javascript">
                                $(window).on('load', function() {
                                    $('#myModal').modal('show');
                                });
                            </script>
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><?php include('search_icon.php'); ?><b><?php echo $find['avatar']; ?></b></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="white-space: pre-line;">
                                            <b><?php echo $find['name']; ?></b>

                                            <?php echo $find['about']; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <?php
                                            if ($_SESSION['same'] != false) {
                                            ?>

                                                <button type="button" class="btn btn-primary" onclick="same()">View Profile</button>
                                            <?php
                                            } else {
                                            ?>
                                                <button type="button" class="btn btn-primary" onclick="change()">View Profile</button>

                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-2">
        </div>
    </div>
</div>


<script>
    function change() {
        window.location.href = "search_profile.php";
    }

    function same() {
        window.location.href = "myprofile.php";
    }
</script>

<footer class="page-footer">

    <!-- Copyright -->
    <div class="footer" style="background-image:url('images/bg.jpg')">© 2020 Copyright:
        <a href="">sujitjaunjal4801@gmail.com</a>
    </div>
    <!-- Copyright -->
</footer>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>