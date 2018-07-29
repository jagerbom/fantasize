<?php
include 'fz_index.php';

if (isset($_POST['fz_register_button'])) {
	fz_register_user();
}
if (isset($_POST['fz_verify_otp'])) {
	fz_verify_otp();
}
?>
