<?php
if (($find['image']) == "profile/") {
?>
    <img src="images/profile.png" class="rounded-circle" alt="User Image" width="50" height="50">
<?php
} else if (($find['image']) != null) {
?>
    <img src="<?php echo $find['image'] ?>" class="rounded-circle" alt="User Image" width="50" height="50">

<?php
} else {
?>
    <img src="images/profile.png" class="rounded-circle" alt="User Image" width="50" height="50">
<?php
}
?>