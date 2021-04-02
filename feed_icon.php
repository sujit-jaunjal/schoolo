<?php
if (($curr_user['image']) == "profile/") {
?>
    <img src="images/profile.png" class="rounded-circle" alt="User Image" width="50" height="50">
<?php
} else if (($curr_user['image']) != null) {
?>
    <img src="<?php echo $curr_user['image'] ?>" class="rounded-circle " alt="User Image" width="50" height="50">

<?php
} else {
?>
    <img src="images/profile.png" class="rounded-circle" alt="User Image" width="50" height="50">
<?php
}
?>