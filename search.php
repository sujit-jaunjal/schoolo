<?php

include('dbconnect.php');


if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
} else {

    $searchTerm = $_GET['term'];

    $query = "SELECT * FROM  registration WHERE avatar LIKE '%" . $searchTerm . "%' ORDER BY avatar ASC";
    $res = mysqli_query($con, $query);

    $avatardata = array();


    if ((mysqli_num_rows($res) > 0)) {
        while (($row = mysqli_fetch_assoc($res))) {
            $data['id'] = $row['id'];
            $data['value'] = $row['avatar'];
            array_push($avatardata, $data);
        }
    }
    echo json_encode($avatardata);
}
