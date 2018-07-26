<?php

function fz_connect_sql() {
	//******** Connect to MYSQL database ********//
	$mysqli = new mysqli("127.0.0.1", "root", "", "fantasize");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	} else {
		return $mysqli;
	}
}
function fz_update_db($mysqli) {
	$sql = "select * from fantasize_user_details where username='$fz_username' or phoneno='$fz_phone_no'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	if(!($row)) {
		$sql = "INSERT INTO fantasize_user_details (id, username, email, password, name, phoneno)
			VALUES (1, '$fz_username', '$fz_email', '$fz_password', '$fz_firstname', '$fz_phone_no')";
		if ($mysqli->query($sql) === TRUE) {
			header('location: fantasize_register_redirect.html');
		}
	} else {
		echo "User is already registered";
	}
}
function fz_register_user()
{
	$fz_firstname		=  $_POST["fz_firstname"];
	$fz_surname		=  $_POST["fz_firstname"];
	$fz_username		=  $_POST["fz_username"];
	$fz_password		=  md5($_POST['fz_password']);
	$fz_phone_no		=  $_POST["fz_phno"];
	$fz_email		=  $_POST["fz_email"];

	$mysqli = fz_connect_sql();
	fz_update_db($mysqli);
	$mysqli->close();
}
?>
