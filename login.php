<?php 
	
	$username = $conn->escape_string($_POST['username']);
	$result = $conn->query("SELECT * FROM users WHERE username='$username'");
	
	//Checking if a user with this username exists
	if ($result->num_rows == 0 ){
		
		echo '<script language="javascript">';
		echo 'alert("User with that username doesnt exist!")';
		echo '</script>';
		
	}
	//User exists
	else{
		
		$user = $result->fetch_assoc();
		
		if( password_verify($_POST['password'],$user['password']) )
		{
			
			$_SESSION['logged_in'] = true;
			$_SESSION['username'] = $user['username'];
		
			echo '<script language="javascript">';
			echo 'alert("You have logged in succesfully!")';
			echo '</script>';
			
			header("refresh:0.1;url= main.php");
		
		}
		else
		{
			echo '<script language="javascript">';
			echo 'alert("You have entered a wrong password, please try again!")';
			echo '</script>';
		}
		
	}
	
?>