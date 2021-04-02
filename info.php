<?php
include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $email = $_SESSION['email'];
    $_SESSION['guide'] = false;

    $que = "SELECT * FROM `registration` WHERE email='$email'";
    $res = mysqli_query($con, $que);

    if ((mysqli_num_rows($res) > 0)) {
        while (($row = mysqli_fetch_assoc($res))) {
            $final = $row;
        }
    }
    $modal = $final['modal'];
    $id = $final['id'];
    $like_avatar = $final['avatar'];

    if ($modal == '0') {
        $_SESSION['guide'] = true;
    }
}

?>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<div class="container-fluid" style="margin-top:50px;">

    <?php
    if ($_SESSION['guide'] == true) {
    ?>
        <script type="text/javascript">
            $(window).on('load', function() {
                $('#myModal').modal('show');
            });
        </script>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: lightblue;">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="font-family:serif;"> Welcome to Schoolo ! </h5>

                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Hey there ! Here's something that you would like to have as your daily driver for socializing. Schoolo is basically an application in which you can be public as well as private.
                            You can search for your friends, tell them to get added here and have experience of this simple yet entertaining webapp. Some quick features of this webapp are -<br>
                            <br><b>Sharing posts as well as thoughts with connections.</b><br>
                            <b>Anonymous texting with whoever you wish !</b><br>
                            <b>Your feed being limited only with your connection's content, no extra time wasted in feed.</b><br>
                            You can discover more as you start using it ! Good luck.
                        </p>
                    </div>
                    <div class="modal-footer" style="background-color: lightblue;">
                        <form method="POST">
                            <button type="button" class="btn btn-primary" name="modal-close" data-dismiss="modal" onclick="close()">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php
    }
?>

<script>
    function close() {
        window.location.href = "feed.php";
    }
</script>


<footer class="page-footer">

    <!-- Copyright -->
    <div class="footer" style="background-image:url('images/bg.jpg')">©Developer:
        <?php
        $_SESSION['search'] = 'im_sujit';
        ?>
        <a href="search_profile.php">Sujit Jaunjal<small>(sujitjaunjal4801@gmail.com)</small></a>
    </div>
    <!-- Copyright -->
</footer>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>