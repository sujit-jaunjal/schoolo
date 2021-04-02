<?php
if (($find['image']) == "profile/") {
?>
    <img src="images/profile.png" class="rounded-circle img-fluid" alt="User Image" width="40" height="50">
<?php
} else if (($find['image']) != null) {
?>
    <img src="<?php echo $find['image'] ?>" class="rounded-circle img-fluid" alt="User Image" width="40" height="40">

<?php
} else {
?>
    <img src="images/profile.png" class="rounded-circle img-fluid" alt="User Image" width="50" height="50">
<?php
}
?>