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
								echo '<li class="current"><a href="main.php">Home</a></li>';
								echo '<li><a href="categories.php">Categories</a><li>';
								echo '<li class="dropdown">';
								echo	 "<a class='dropbtn'><img src='profile.png'>".$_SESSION['username']."</a>";
								echo	 "<div class='dropdown-content'>";
								echo	 "<a href='logout.php'>Logout</a>";
								echo	"</div>";
								echo '</li>';
							}
							else{
								echo '<li class="current"><a href="main.php">Home</a></li>';
								echo '<li><a href="categories.php">Categories</a><li>';
								echo '<li><a href="#login"">Login</a></li>';
							}
						?>
						
					</ul>
				</nav>
			</div>
		</header>
		
	
		
		<section id="login">
			<div class="container">
				<form action="main.php" method="post">
					
					<?php
							if(isset($_SESSION['logged_in']) || isset($_SESSION['admin-login'])) {
								echo "<div class='wb'>Welcome back ".$_SESSION['username']."!<div>";
								echo "<div class='redirect'>You can check out our categories <a href='categories.php'>here!</a></div>";
								echo "<div class='redirect'>You can check out your orders <a href='orderhistory.php'>here!</a></div>";	
								echo "<div class='redirect'>You can check out our item photo section <a href='reviews.php'>here!</a></div>";
								if (isset($_SESSION['admin-login'])){
									echo "<div class='redirect'>You can edit this page <a href='adminpage.php'>here!</a></div>";
								}
								
								
						
							}
							else{
								echo '<h1>Sign In</h1>';
								echo '<input type="text" placeholder="Enter your Username" class="input2" name="username" required>';
								echo '</br>';
								echo '<input type="password" placeholder="Enter your Password" class="input3" name="password" required>';
								echo '<br><br><br>';
								echo '<button type="sumbit" class="button_1" name="login" >Connect</button>';
								echo '<br><br><br>';
								echo '<a href="registerpage.php">Dont have an account? Sing up now!</a>';
								echo '<br>';
								if(empty($_SESSION['logged_in'])) {
									echo '<div class="adm"><a href="adminlogin.php">Login as administrator</a></div>';
								}
							}
					?>
					
				</form>
			</div>
		</section>
		
		<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if (isset($_POST['login'])) {
					require 'login.php';
				}
			}
		?> 
		
		<section id="newsletter">
			<div class="container">
				<h1>Subscribe to our newsletter to recieve exclusive offers!</h1>
				<form>
					<input type="email" placeholder="Enter Email..." >
					<button type="sumbit" class="button_2">Subscribe</button>
				</form>
				
			</div>
		</section>
		
		<section id="boxes">		
			<div class="container">
			
				<div class="box">
					<img src="shipping.png">
					<h2>Free Shiping & Return</h2>
				</div>
				<div class="box">
					<img src="online.jpg" class="image2">
					<h2>Online Support</h2>
				</div>
				<div class="box">
					<img src="track.png">
					<h1>Track Your Order</h1>
				</div>
				
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
