<?php
if (($arr[$ctr]['image']) == "profile/") {
?>
    <img src="images/profile.png" class="rounded-circle" alt="User Image" width="50" height="50">
<?php
} else if (($arr[$ctr]['image']) != null) {
?>
    <img src="<?php echo $arr[$ctr]['image']; ?>" class="rounded-circle" alt="User Image" width="50" height="50">

<?php
} else {
?>
    <img src="images/profile.png" class="rounded-circle" alt="User Image" width="50" height="50">
<?php
}
?>