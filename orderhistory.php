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
		
		
		<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if (isset($_POST['delete-order']) ) {
					
					$deletedOrder = $_POST['deleted-order-id'];
					
					echo '<script language="javascript">';
					echo 'confirm("Are you sure?")';
					echo '</script>';
					
					$sql = "DELETE FROM orders WHERE orderid = '$deletedOrder' "; 	//Deletes the order
					$sql2 = "DELETE FROM boughtitems WHERE itemorderid = '$deletedOrder' ";	//Deletes the items that match the order
					
					if ($conn->query($sql) == TRUE){
						
						if ($conn->query($sql2) == TRUE){
							echo '<script language="javascript">';
							echo 'alert("Deleted Succesfully")';
							echo '</script>';
							
							header("refresh:0.5;url= orderhistory.php");
							
						}
						else{
							echo '<script language="javascript">';
							echo 'alert("Something went wrong!")';
							echo '</script>';
							
							header("refresh:0.5;url= orderhistory.php");
						}
					}
					
				}
			}
		?> 
		
		<section id="recentorders">
				
			<h1>Recent Orders</h1>
			
			<div class="orders">
			
				<div class="order-row">
					<span class="order-no  order-column">Order No.</span>
					<span class="order-date  order-column">Order Date</span>
					<span class="order-items  order-column">Total Items</span>
					<span class="order-price  order-column">Total Price</span>
					<span class="order-details  order-column">Details</span>
				</div>
				
				
				<?php
						$usersname = $_SESSION['username'];
						
						$result = $conn->query("SELECT * FROM orders WHERE username= '$usersname' ");
						if( $result-> num_rows == 0){
							echo "<div class='empty'>No recent orders!</div>";

						}
						else
						{
							while ($order = $result->fetch_assoc())
							{
								
								echo '<div class="order">';
								
								echo 	'<div class="order-info">';
								echo 		'<input type="text" class="orderId" value="'.$order['orderid'].'" style="display:none">';
								echo		'<span class="order-column">'.$order['orderid'].'.</span>';
								echo		'<span class="order-column">'.$order['date'].'</span>';
								echo		'<span class="order-column">'.$order['totalitems'].'</span>';
								echo		'<span class="order-column">'.$order['totalprice'].'&euro;</span>';
								echo		'<span class="order-column"><button type="button" class="show-hidden" >>Show Items</button></span>';
								echo		'<form  method="post" action="orderhistory.php");">';
								echo			'<input type="text" class="deleted-order-id" name="deleted-order-id" value="'.$order['orderid'].'" style="display:none">';
								echo			'<span class="order-column"><button type="submit" name="delete-order" class="delete-order">DELETE</button></span>';
								echo		'</form>';
								echo	'</div>';
								
								echo   '<div class="hidden-items" id="hidden" style="display:none">';
								echo 		'<div class="container">';
								
								$order_id = $order['orderid'];
								$bought = $conn->query("SELECT * FROM boughtitems WHERE itemorderid = '$order_id' ");
								
								while ($boughtItem = $bought->fetch_assoc())
								{
									echo 		'<div class="bought-item">';
									echo 			'<img src="'.$boughtItem['itemphoto'].'">';
									echo			'<p>'.$boughtItem['itemname'].'<span> x'.$boughtItem['itemquantity'].'</span></p>';
									echo 			'<p>Price : '.$boughtItem['itemprice'].' &euro; </p>';
									echo 		'</div>';
								} 
								echo   		'</div>';
								echo   '</div>';
								
								echo '</div>';
								
							}
						}
					?>
			
				
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
