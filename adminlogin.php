<?php 
	require 'config.php';
	session_start();
?>
	

<!DOCTYPE html>
<html>

	<head>
		<title>Ε-Medicine</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="maincss.css" type="text/css">
		<link rel="icon" type="image/gif/png" href="logo.jpg">
		<script src="scripts.js"></script>
		
	</head>
	
	<?php 
	
	
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if (isset($_POST['login-adm'])) {
					
					if(empty($_SESSION['logged_in'])) {
					
					
						$adminusername = $conn->escape_string($_POST['admin-username']);
						$adminpassword = $conn->escape_string($_POST['admin-password']);
					
						if ( $adminusername === "admin" && $adminpassword === "admin")
						{
							
							$_SESSION['admin-login'] = true;
							$_SESSION['username'] = "Admin";
							header('location:adminpage.php');
			
						}
						else{
							
							echo '<script language="javascript">';
							echo 'alert("You have entered wrong username or password!")';
							echo '</script>';
							
							header("refresh:0.1;url= adminlogin.php");
							
						}
					}
					else{
						echo '<script language="javascript">';
						echo 'alert("You need to logout as a regular user in order to login as an admin!")';
						echo '</script>';
							
						header("refresh:0.1;url= main.php");
					}
				}
			}
	?>
	
	<body>
		
		<header>
			<div class="container">
			
				<div id="branding">
					<a href="main.php"><h1><span class="highlight">E</span>-Medicine</h1></a>
				</div>
				<span class="myphoto">
					<a href="main.php"><img src="mylogo.png"></a>
				</span>
				<nav>
					<ul>
						<?php
							if(isset($_SESSION['logged_in']) || isset($_SESSION['admin-login'])) {
								echo '<li><a href="main.php">Home</a></li>';
								echo '<li><a href="categories.php">Categories</a><li>';
								echo '<li class="dropdown">';
								echo	 "<a class='dropbtn'><img src='profile.png'>".$_SESSION['username']."</a>";
								echo	 "<div class='dropdown-content'>";
								echo	 "<a href='logout.php'>Logout</a>";
								echo	"</div>";
								echo '</li>';
							}
							else{
								echo '<li><a href="main.php">Home</a></li>';
								echo '<li><a href="categories.php">Categories</a><li>';
								echo '<li><a href="#login"">Login</a></li>';
							}
						?>
						
					</ul>
				</nav>
			</div>
		</header>
		
		 
		
		<section id="admin-login">
			<div class="container">
				
				<h1>Login as an administrator</h1>
				<form method="post" action="adminlogin.php">
					<input type="text" name="admin-username" placeholder="Enter Username..." required>
					<br>
					<input type="password" name="admin-password" placeholder="Enter Password..." required>
					<br>
					<button type="submit" name="login-adm">Log In</button>
				</form>
			</div>
		</section>
		
		
		<section id="info">
	
			<div class="container">
				<div class="infos">
					<h2>Orders</h2>
					<a href="main.php">Shipping Methods</a>
					<br>
					<a href="main.php">Payment Methods</a>
					<br>
					<a href="main.php">Track your Order</a>
					<br>
					<a href="main.php">Product Returns</a>
					
				</div>
				<div class="infos">
					<h2>Company</h2>
					<a href="main.php">Contact</a>
					<br>
					<a href="main.php">FAQ</a>
					<br>
					<a href="main.php">User Agreements</a>
					<br>
					<a href="main.php">About Us</a>
				</div>
				<div class="infos">
					<div class="paym">
						<h2>Partners With</h2>
						<img src="mastercard.png">
						<img src="visa.jpg">
						<img src="paypal.png">
					</div>
					<div class="social">
						<h2>Follow us on<h2>
						<img src="facebook.png">
						<img src="instagram.png">
						
					</div>
				</div>
				
			</div>
		</section>
		
		
		<footer>
			<p>Copyright &copy; 2020 E-Medicine | All Rights Reserved</p>
		</footer>
		
	</body>
</html>
