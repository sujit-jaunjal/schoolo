<?php
if (($final['image']) == "profile/") {
?>
    <center><img src="images/profile.png" class="rounded-circle img-fluid" alt="User Image" width="240" height="216"></center>
<?php
} else if (($final['image']) != null) {
?>
    <center><img src="<?php echo $final['image'] ?>" class="rounded-circle img-fluid" alt="User Image" width="240" height="216"></center>

<?php
} else {
?>
    <center><img src="images/profile.png" class="rounded-circle img-fluid" alt="User Image" width="240" height="216"></center>
<?php
}
?>