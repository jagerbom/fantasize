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
function fz_rd_missing_fields() 
{
	echo '
<html>
<head>
<link href="fz_style.css" type="text/css" rel="stylesheet"/>
</head>
<body>

<div id="header_wrapper">
 <div id="header">
 <li id="sitename"><a href="https://vaibhavkhareee.wixsite.com/fantasize/home">Fantasize</a></li>
 </div>
</div>

<div id="wrapper">
<div id="div1">
	<p> Play fantasy. Do betting. Earn Zombies</p>
<img src="fantasize_images/fz_zombie_money.jpeg">
</div>
<div id="div2">
<p>One or more fields are empty. Press the back button if you do not want loose the progress with the form or you will be redirected to home page</p>
<p> in  <span id="countdowntimer">10 </span> Seconds</p>

<script type="text/javascript">
    var timeleft = 10;
    var downloadTimer = setInterval(function(){
    timeleft--;
    document.getElementById("countdowntimer").textContent = timeleft;
    if(timeleft <= 0)
        clearInterval(downloadTimer);
    },1000);
</script>
</body>
</html>
<meta http-equiv="Refresh" content="10; url=fz_home.html">
';
}

function fz_rd_user_registered() 
{
	echo '
<html>
<head>
<link href="fz_style.css" type="text/css" rel="stylesheet"/>
</head>
<body>

<div id="header_wrapper">
 <div id="header">
 <li id="sitename"><a href="https://vaibhavkhareee.wixsite.com/fantasize/home">Fantasize</a></li>
 </div>
</div>

<div id="wrapper">
<div id="div1">
	<p> Play fantasy. Do betting. Earn Zombies</p>
<img src="fantasize_images/fz_zombie_money.jpeg">
</div>
<div id="div2">
<h1>User is already registered</h1>
<p> redirecting to home page in  <span id="countdowntimer">10 </span> Seconds</p>

<script type="text/javascript">
    var timeleft = 5;
    var downloadTimer = setInterval(function(){
    timeleft--;
    document.getElementById("countdowntimer").textContent = timeleft;
    if(timeleft <= 0)
        clearInterval(downloadTimer);
    },1000);
</script>
</body>
</html>
<meta http-equiv="Refresh" content="5; url=fz_home.html">
';
}

function fz_register_user()
{
	$fz_firstname		=  $_POST["fz_firstname"];
	$fz_surname		=  $_POST["fz_surname"];
	$fz_username		=  $_POST["fz_username"];
	$fz_password		=  md5($_POST['fz_password']);
	$fz_phone_no		=  $_POST["fz_phno"];
	$fz_email		=  $_POST["fz_email"];

	if((empty($fz_firstname)) ||
	 	(empty($fz_username)) ||
	 	(empty($fz_password)) ||
		(empty($fz_phone_no))) {
		goto end;
	}

	$mysqli = fz_connect_sql();

	$sql = "select * from fantasize_user_details where username='$fz_username'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	if(!($row)) {
		$sql = "INSERT INTO fantasize_user_details (id, username, email, password, name, phoneno)
			VALUES (1, '$fz_username', '$fz_email', '$fz_password', '$fz_firstname', '$fz_phone_no')";
		if ($mysqli->query($sql) === TRUE) {
			header('location: fz_reg_rd.html');
		}
	} else {
		fz_rd_user_registered();
	}
	$mysqli->close();
	return;
end:
	fz_rd_missing_fields();
	return;
}

function fz_verify_otp()
{
#$fz_otp = "1234";

if (isset($_POST['submit_otp'])) {
	$fz_user_input_otp = $_POST["fz_otp_verify"];
	if ($fz_user_input_otp == $_POST['otp_generated']){
		header("location: fz_user_hompage.html");
	}
}

$fz_phno           =  $_POST["fz_phno"];
$fz_authkey = "226858AlxGywXsyS5b4f9395";
$fz_otp_generated = rand(1000,9999);
$fz_url = "http://control.msg91.com/api/sendotp.php?otp_length=4&authkey=$fz_authkey&message=your OTP is $fz_otp_generated&sender=fantasize&mobile=$fz_phno&otp=$fz_otp_generated";
$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "$fz_url",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "",
	CURLOPT_SSL_VERIFYHOST => 0,
	CURLOPT_SSL_VERIFYPEER => 0,
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	//echo $response;
}
echo '
<html>
<head>
<link href="fz_style.css" type="text/css" rel="stylesheet"/>
</head>
<body>

<div id="header_wrapper">
 <div id="header">
 <li id="sitename"><a href="https://vaibhavkhareee.wixsite.com/fantasize/home">Fantasize</a></li>
 </div>
</div>

<div id="wrapper">
<div id="div1">
	<p> Play fantasy. Do betting. Earn Zombies</p>
<img src="fantasize_images/fz_zombie_money.jpeg">
</div>
<div id="div2">
<h1>You have regsitered successfully</h1>
<p> You are just one step away from earning Zombies.</p>
<p> Please verify your mobile number.</p>
<form method =  "post" action="fantasize_register_verify_otp.php">
<li><input type="text" value="<?php echo $fz_phno?>"></li>
<li><input type="text" placeholder="OTP" name="fz_otp_verify"></li>
<li><input type="submit" value="submit" name="submit_otp"></li>
<li><input type="hidden" value="<?php echo $fz_otp_generated?>" name="otp_generated"></li>

</body>
</html>
' ;
}
?>
