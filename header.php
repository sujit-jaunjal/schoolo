<?php

session_start();
include('dbconnect.php');
include('style.php');

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
} else {

    if (!(isset($_SESSION['email']))) {

        header('location:login.php');
    }

    $email = $_SESSION['email'];
    $query = "SELECT *FROM `registration` WHERE email='$email'";
    $exec = mysqli_query($con, $query);


    if ((mysqli_num_rows($exec) > 0)) {
        while (($row = mysqli_fetch_assoc($exec))) {
            $final = $row;
        }
    }
}
?>


<html>

<body class="sb-nav-fixed" onload="updateScroll()">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="background-image:url('images/bg.jpg')">


        <a class="navbar-brand" href="">Schoolo !</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" style="color:#000000;" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="hidden" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" style="color:#000000;" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php include('profile_icon.php');  ?><?php echo $final['avatar'] ?></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="feed.php"><i class="fas fa-home fa-fw"></i> Home</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="edit_profile.php"><i class="fa fa-user-circle" aria-hidden="true"></i>Edit Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Main Menu</div>
                        <a class="nav-link" href="feed.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            My Feed
                        </a>
                        <a class="nav-link" href="profile_search.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-search fa-fw"></i></div>
                            Search
                        </a>
                        <a class="nav-link" href="info.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                            Info about Schoolo !
                        </a>
                        <div class="sb-sidenav-menu-heading">Personal</div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                            Messaging
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="user_msg.php">Chat as <?php echo $final['avatar'] ?></a>
                                <a class="nav-link" href="anonymous.php">Chat as Anonymous !</a>
                                <a class="nav-link" href="all_msgs.php">My Messages</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fa fa-rss" aria-hidden="true"></i></div>
                            Manage Network
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link" href="invitation.php">
                                    <div class="sb-nav-link-icon"></i></div>
                                    Invitations
                                </a>
                                <a class="nav-link" href="request.php">
                                    <div class="sb-nav-link-icon"></i></div>
                                    My requests
                                </a>
                            </nav>
                        </div>
                        <a class="nav-link" href="my_connections.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                            My Connections
                        </a>
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="notification.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-bell" aria-hidden="true"></i></div>
                            Notifications
                            <?php
                            if ($_SESSION['bday'] == true || $_SESSION['new_msg'] == true) {
                            ?>
                                &nbsp;&nbsp; <small><i class="fa fa-circle" aria-hidden="true"></i></small>
                            <?php
                            }
                            $_SESSION['bday'] = false;
                            $_SESSION['new_msg'] = false;
                            ?>
                        </a>
                        <a class="nav-link" href="myprofile.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
                            My Profile
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $final['name'] ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>