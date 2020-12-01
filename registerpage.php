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
		
	
		
		
		<section id="signup">
			<div class="container">
				
				<form action="registerpage.php" method="post">
					<h1>Create an Account</h1>
					<div class="inputs">
						<h3>Username:</h3>
						<input type="text" name="username" required>
					</div>
					<div class="inputs">
						<h3>First Name:</h3>
						<input type="text" name="firstname" required>
					</div>
					<div class="inputs">
						<h3>Last Name:</h3>
						<input type="text" name="lastname" required>
					</div>
					<div class="inputs">
						<h3>E-mail:</h3>
						<input type="email" name="email" required>
					</div>
					<div class="inputs">
						<h3>Phone Number:</h3>
						<input type="tel" name="phone" required>
					</div>
					<div class="inputs">
						<h3>Country:</h3>
						<input list="country" name="country" required>
						<datalist id="country">
							<option value="Greece">
							<option value="Italy">
							<option value="France">
							<option value="Spain">
							<option value="United States">
						</datalist>
					</div>
				
					<input type="checkbox" name="aggree" required>
					<a href="main.html"> I have read the user agreement</a>
					<br>
					<button type="sumbit" name="register">CREATE ACCOUNT</button>
				</form>
			</div>
		</section>
		
		<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if (isset($_POST['register'])) {
					require 'register.php';
				}
			}
		?> 
		
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
