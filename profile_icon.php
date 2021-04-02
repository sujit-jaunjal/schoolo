<?php
if (($final['image']) == "profile/") {
?>
    <img src="images/profile.png" class="rounded-circle" alt="User Image" width="50" height="50">
<?php
} else if (($final['image']) != null) {
?>
    <img src="<?php echo $final['image'] ?>" class="rounded-circle " alt="User Image" width="50" height="50">

<?php
} else {
?>
    <img src="images/profile.png" class="rounded-circle" alt="User Image" width="50" height="50">
<?php
}
?>