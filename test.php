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
						<li><a href="main.php">Home</a></li>
						<li class="dropdown">
							<a href="categories.html" class="dropbtn">Categories</a>
							<div class="dropdown-content">
								<a href="vitamins.html">Vitamins</a>
								<a href="antibiotics.html">Antibiotics</a>
								<a href="womenprods.html">Women Products</a>
								<a href="menprods.html">Men Products</a>
								<a href="hairprods.html">Body & Hair Hygiene</a>
								<a href="food.html">Food Supplements</a>
							</div>
						</li>
						<li><a href="soon.html">Cart</a></li>
						<li><a href="soon.html">Contact</a></li>
					</ul>
				</nav>
			</div>
		</header>
		
		<button type="button" onclick="aman()">ante</button>
		<section id="info">
	
			<div class="container">
				<div class="infos">
					<h2>Orders</h2>
					<a href="main.html">Shipping Methods</a>
					<br>
					<a href="main.html">Payment Methods</a>
					<br>
					<a href="main.html">Track your Order</a>
					<br>
					<a href="main.html">Product Returns</a>
					
				</div>
				<div class="infos">
					<h2>Company</h2>
					<a href="main.html">Contact</a>
					<br>
					<a href="main.html">FAQ</a>
					<br>
					<a href="main.html">User Agreements</a>
					<br>
					<a href="main.html">About Us</a>
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
