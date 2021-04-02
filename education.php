<?php

include('header.php');

if (mysqli_connect_error()) {
    echo "Connection error!" . mysqli_connect_error();
    exit();
} else {

    $email = $_SESSION['email'];

    if (isset($_POST['submit'])) {

        $school = $_POST['school'];
        $degree = $_POST['degree'];
        $field = $_POST['field'];
        $from = $_POST['from'];
        $to = $_POST['to'];

        $query = "INSERT INTO education(email, school, degree, edu_field, edu_from, edu_to) VALUES ('$email','$school','$degree','$field','$from','$to');";
        mysqli_query($con, $query);
        echo "<script>alert('Information Saved...');</script>";
        echo "<script>window.location.href='edit_profile.php';</script>";
    }
}
?>
<!-- 
<style>
    .card {
        border: none;
    }
</style> -->

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <div class="card-group" style="margin-top: 100px;">
                <div class="card">
                    <div class="form">
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <i class="fa fa-university" aria-hidden="true"></i>
                                    <label for="name"><b>School Name :</b></label>
                                    <input type="text" name="school" class="form-control">
                                </div><br>
                                <div class="form-group">
                                    <label for="degree"><b>Degree :</b></label>
                                    <input type="text" name="degree" class="form-control">
                                </div><br>

                                <div class="form-group">
                                    <label for="field"><b>Field :</b></label>
                                    <input type="text" name="field" class="form-control">
                                </div><br>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="from"><b>From :</b></label>
                                            <input type="number" name="from" class="form-control">
                                        </div><br>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="to"><b>To :<small>(or expected date)</small></b></label>
                                            <input type="number" name="to" class="form-control">
                                        </div><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="submit">Save</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
        </div>
    </div>
</div>


<?php
include('footer.php');
?>