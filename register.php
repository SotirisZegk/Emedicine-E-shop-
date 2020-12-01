<?php

	function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}	//turn the array into a string
	
	$newpassword = randomPassword(); 
	$_POST['password'] =  $newpassword ;
	
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['firstname'] = $_POST['firstname'];
	$_SESSION['lastname'] = $_POST['lastname'];
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['phone'] = $_POST['phone'];
	$_SESSION['country'] = $_POST['country'];
	
	
	$username = $conn->escape_string($_POST['username']);
	$firstname = $conn->escape_string($_POST['firstname']);
	$lastname = $conn->escape_string($_POST['lastname']);
	$email = $conn->escape_string($_POST['email']);
	$phone = $_POST['phone'];
	$country = $conn->escape_string($_POST['country']);
	$password = $conn->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
	$hash = $conn->escape_string( md5( rand(0,1000) ) );
	
	//Checking if user with that username already exists
	$result = $conn->query("SELECT * FROM users WHERE username='$username'") or die($mysqli->error());
	
	if ($result->num_rows > 0 ) {
		
		echo '<script language="javascript">';
		echo 'alert("This username already exists!")';
		echo '</script>';
		
	}
	else{
		
		$sql = "INSERT INTO users (username, first_name, last_name, email, phone_number, country, password, hash) "
		. "VALUES ('$username' , '$firstname' , '$lastname', '$email' , '$phone', '$country', '$password', '$hash')";
		
		if ( $conn->query($sql) ) {
			
			echo '<script language="javascript">';
			echo 'alert("You have succesfully registered in our page!")';
			echo '</script>';
			
			$to = $email;
			$subject = 'Account Verification ( Emedicine.com)';
			$message_body = '
			Hello '.$firstname.' ,
			
			Thank you for signing up!
			
			Your password is : '.$newpassword;
			
			mail( $to, $subject, $message_body);
			
			
			header("refresh:0.1;url= main.php");
			
			
		}
		else{
			$_SESSION['message'] = 'Registration failed!';
			header("location: registerpage.php");
			
		}
	}
?>