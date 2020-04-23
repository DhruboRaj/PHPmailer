<?php
//index.php

$error = '';
$name = '';
$host = '';
$name= '';
$port = '';
$email = '';
$semail = '';
$mailuser = '';
$pass = '';
$subject = '';
$message = '';

function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}

if(isset($_POST["submit"]))
{
	if(empty($_POST["name"]))
	{
		$error .= '<p><label class="text-danger">Please Enter your Name</label></p>';
	}
	else
	{
		$name = clean_text($_POST["name"]);
		if(!preg_match("/^[a-zA-Z ]*$/",$name))
		{
			$error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
		}
	}
	if(empty($_POST["email"]))
	{
		$error .= '<p><label class="text-danger">Please Enter your Email</label></p>';
	}
	else
	{
		$email = clean_text($_POST["email"]);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error .= '<p><label class="text-danger">Invalid email format</label></p>';
		}
	}
	if(empty($_POST["semail"]))
	{
		$error .= '<p><label class="text-danger">Please Enter your Email</label></p>';
	}
	else
	{
		$email = clean_text($_POST["semail"]);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error .= '<p><label class="text-danger"> email format</label></p>';
		}
	}
	if(empty($_POST["subject"]))
	{
		$error .= '<p><label class="text-danger">Subject is required</label></p>';
	}
	else
	{
		$subject = clean_text($_POST["subject"]);
	}
   
    
	if(empty($_POST["message"]))
	{
		$error .= '<p><label class="text-danger">Message is required</label></p>';
	}
	else
	{
		$message = clean_text($_POST["message"]);
	}
	if($error == '')
	{
		require 'class/class.phpmailer.php';
		$mail = new PHPMailer;
		$mail->IsSMTP();								//Sets Mailer to send message using SMTP
		$mail->Host = 'smtp.gmail.com';//$_POST["host"];		//Sets the SMTP hosts of your Email hosting, this for Godaddy
		$mail->Port = '587'; //$_POST["port"];								//Sets the default SMTP server port
		$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
		$mail->Username = 'yourmail@gmail.com';	//$_POST["mailuser"]; //				//Sets SMTP username
		$mail->Password =  'password'; // $_POST["pass"]; 					//Sets SMTP password
		$mail->SMTPSecure = 'tls';							//Sets connection prefix. Options are "", "ssl" or "tls"
		$mail->SetFrom=  $_POST["semail"];
		$mail->SetFromName=  $_POST["name"];
		
		$mail->From = $_POST["semail"];					//Sets the From email address for the message
		$mail->FromName = $_POST["name"];				//Sets the From name of the message
		//$mail->AddAddress('abc@xyz.com', 'Name');		//Adds a "To" address
		$mail->AddBCC($_POST["email"], $_POST["name"]);	//Adds a "Cc" address
		$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
		$mail->IsHTML(true);							//Sets message type to HTML				
		$mail->Subject = $_POST["subject"];				//Sets the Subject of the message
		$mail->Body = $_POST["message"];				//An HTML or plain text message body
		if($mail->Send())								//Send an Email. Return true on success or false on error
		{
			$error = '<label class="text-success">The mail Has Been Sent</label>';
		}
		else
		{
			$error = '<h1> <label class="text-danger" align="center">This is a trial. You need to setup your host & username</label></h1>';
		}
		$name = '';
		$email = '';
		$semail = '';
		$pass = '';
		$subject = '';
		$message = '';
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title> Dhrubo's Mailer</title>
		<link rel="icon" type="image/png" href="https://lh3.googleusercontent.com/pHksCffcFwsGie3WekxpQo1o-6vWAS0pwG_hhumk2r65c-SQXWzceNuuZpr0F22-gARS76fjZHwJr1C6pu6NVJUn6ENP5k2_mpzjtqJxcV0xOrFIpD1dOVfcDe4Zp1Rt0JAMqBx3rgBAUyrwGq_T7Tw9tHyopT8Mk_yzcV_d7oI2WBfraD_HppzSRr7HeM0C0FEPxviNQs3ZWfWPeOzbKgdu7nUsKvUaecl31cjB5_O2stLaI3bwSc9shGL0_6tMF4uDMc_yGB2-IBfY8JHjDFJ4H6M9pkHwJq20aoOFrahfq9RhUMm1ijXK-ZAgz2Cy81fgJAvamOoIPdnKAfmouuzt2lEk1jG68voerlyHJSfT9d4jYsBLiyAzmLE70N2Alc4_0LyqSHhxJc4_f57b-TcPuTKE2SyjTPX9JczTx4-IHsdi7_AdJEdpcnNRhU1PdhbWH9Kc8SbIPVZjRQonqPv8FkxDLvrhlno37_GCOvZWBju4kQ1fEAmJa-Spl2bZLC1drqKUwqQily57g-wElCAeYWEKWQo9CVLdZ9zjhfwnr8l6HMZ_Vv0-Doi5qow7CHQabUONmXPfSh8Tdze3YhhQXmxIlvdRURceHUo3gnu8iGboP-eauGdyRwBSrEzeBwu8-iRVzNU1muEBSOzy0aK4AbpryJOBzRzJa7JDBHnmZKnvnJEuPH8qTKfe=w166-h136-no">
		<script src="css/jquery.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="css/bootstrap.min.js"></script>
	</head>
	<body background="email.svg">
		<br />
		<div class="container">
			<div class="row"  >
				<div class="col-md-8" style="margin:0 auto; float:none;">
					<h1 align="center" style="background-color:#D7A9E3EFF";>Dhrubo's Mailer</h1>
					
					<br />
			<div class="col-md-8" style="margin:0 auto; float:none; background-color:#87CEEB;">
					<?php echo $error; ?>
					 <tr > <td> <form method="post" background="skyblue">
									
						<div class="form-group">
							<label>Enter Sender Email That you Want</label>
							<input type="text" name="semail" class="form-control" placeholder="Enter Email That you Want" value="<?php echo $semail; ?>" />
						</div>
						
						<div class="form-group">
							<div class="form-group">
							<label>Sender Name</label>
							<input type="text" name="name" placeholder="Enter Name" class="form-control" value="<?php echo $name; ?>" />
						</div>
						<div class="form-group">
							<label>Target Email</label>
							<input type="text" name="email" class="form-control" placeholder="Enter Email" value="<?php echo $email; ?>" />
						</div>
							<label> Subject</label>
							<input type="text" name="subject" class="form-control" placeholder="Enter Subject" value="<?php echo $subject; ?>" />
						</div>
						<div class="form-group">
							<label> Message</label>
							<textarea name="message" class="form-control" placeholder="Enter Message"><?php echo $message; ?></textarea>
						</div>
						<div class="form-group" align="center">
							<input type="submit" name="submit" value="Submit" class="btn btn-info" /> </table>
						</div> </td> </tr>
					</form>
				<a href="https://facebook.com/Dhruboraj.roy/?_rdc=1&_rdr" target="_blank" Title="Powered by Dhrubo"> <h1 align="Center"> <img src="css/Devloper.jpg" alt="Devloper Pic"></h1></h1> </a> </div>
			</div> </div>
		</div>
	</body>
</html>





