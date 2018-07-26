<?php
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

?>
<head>
<link href="fantasize_style.css" type="text/css" rel="stylesheet"/>
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
<li><input type="text" placeholder="<?php echo $fz_phno?>"></li>
<li><input type="text" placeholder="OTP" name="fz_otp_verify"></li>
<li><input type="submit" value="submit" name="submit_otp"></li>
<li><input type="hidden" value="<?php echo $fz_otp_generated?>" name="otp_generated"></li>

</body>
</html>
