<?php

$DEBUG	=	0;
$fz_firstname		=  $_POST["fz_firstname"];
$fz_surname		=  $_POST["fz_firstname"];
$fz_username		=  $_POST["fz_username"];
$fz_password		=  md5($_POST['fz_password']);
$fz_phone_no		=  $_POST["fz_phno"];
$fz_email		=  $_POST["fz_email"];

//******* DEBUG PRINTS ********//
if ($DEBUG) {
	echo nl2br("\n Name is $fz_firstname $fz_surname");
	echo nl2br("\n username is $fz_username");
	echo nl2br("\n password is $fz_password");
	echo nl2br("\n phone no is $fz_phone_no");
}

//******** Connect to MYSQL database ********//
$mysqli = new mysqli("127.0.0.1", "root", "", "fantasize");
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
	if ($DEBUG) {
		echo nl2br("\n Connection to database successfull !!");
	}
}

$sql = "select * from fantasize_user_details where username='$fz_username' or phoneno='$fz_phone_no'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
if(!($row)) {
	$sql = "INSERT INTO fantasize_user_details (id, username, email, password, name, phoneno)
		VALUES (1, '$fz_username', '$fz_email', '$fz_password', '$fz_firstname', '$fz_phone_no')";
	if ($mysqli->query($sql) === TRUE) {
		if ($DEBUG){
			echo " query is" . $sql . "<br>" . $conn->error;
			echo nl2br(" \n New record created successfully");
		}
		header('location: fantasize_register_redirect.html');
	} else {
		if($DEBUG){
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
} else {
	echo "User is already registered";
}
//******** Close the connection to database ********//
$mysqli->close();
?>
