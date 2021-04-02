<?php
// define('DB_SERVER', 'schoolo.cjh7xudcbhor.ap-south-1.rds.amazonaws.com:3305');
// define('CHARSET', 'utf8mb4');
// define('DB_USER', 'root');
// define('DB_PASS', 'sujit123');
// define('DB_NAME', 'schoolo');
// $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);



$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "website"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
