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
		<script src="scripts.js" async></script>
	</head>
	
	<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if (isset($_POST['send'])) {
					require 'order.php';
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
		
		
		<section id="items">
			<div class="categ">
			
				<h2>Categories:</h2>
				
					<?php
						
						//Sidebar categories names
						$result = $conn->query("SELECT * FROM categories");
						if( $result-> num_rows == 0){
							echo "No categories right now";

						}
						else
						{
							while ($categories = $result->fetch_assoc())
							{
								
								echo    '<form action="itempage.php" method="post">';
								echo 		'<button name="btn-categ-id" value='.$categories['id'].'>'.$categories['name'].'</button>';
								echo 	'</form>';

								
							}
						}
					?>				
				
			
			</div>

			<div class="main" >
		
				
				<?php
				
					//Category id = Items category id
					if ($_SERVER['REQUEST_METHOD'] == 'POST')
					{
						if (isset($_POST['btn-categ-id'])) {
							$itemcateg = $_POST['btn-categ-id'];
						}
					}
					
					//Tittle that matches category id
					$categnames = $conn->query("SELECT name FROM categories WHERE id='$itemcateg'");
					$title  = $categnames->fetch_assoc();

					echo   '<div class="mytitle">';
					echo   		'<h1>'.$title['name'].'<h1>';
					echo   '</div>';
					
					
					
					//Items that match categories id
					$randomitem=0;
					
					$result = $conn->query("SELECT * FROM items WHERE category_id='$itemcateg'");

					if( $result-> num_rows == 0){
						
						echo '<div class="empty">No available items in this category right now</div>';

					}
					else
					{
						while ($items = $result->fetch_assoc())
						{
							
							echo '<div class="item">';
							echo	'<h2 class="item-title">'.$items["name"].'</h2>';
							echo	'<img  class="item-image" src='.$items["image"].'>';
							echo	'<p class="item-price">Price:'.$items["price"].' &euro; </p>';
							echo	'<p>Quantity:<input type="number" value="1" min="1" max="5" class="item-ammount"><p>';
							echo	'<button type="button" class="item-button" id='.$randomitem++.'>Add to cart</button>';
							echo '</div>';
						}
					}
				
				?>
		
			</div>
			
		
		</section>
		
		<section id="randomitems">
			<div class="container">
				<h1>Use this button to pick some random items!</h1>
				<button type="sumbit" class="random-button" onclick="myRandom()">RANDOMIZE!</button>
			<div>
		</section>
		
		
		
		
		
		<form action="itempage.php" method="post" name="Form">
		
			<div id="mySidebar" class="sidebar">
				<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
				<section class="container content-section">
					<div class="header">
						<img src="cart.png">
					</div>
					<div class="cart-row">
						<span class="cart-item  cart-column">ITEM</span>
						<span class="cart-prices  cart-column">PRICE</span>
						<span class="cart-quantity  cart-column">QUANTITY</span>
					</div>
					<div class="cart-items">
					   
					</div>
					<div class="cart-total">
						<strong class="cart-total-title">Total:</strong>
						<span class="cart-total-price">0.00 &euro;</span>
					</div>
				
					<button class="purchase" type="button" onclick="openInformation()" <?php if(empty($_SESSION['logged_in'])) { ?> disabled <?php } ?>>PURCHASE</button>
					
				<?php
				
					if(empty($_SESSION['logged_in'])) {
						echo '<div class="unable">You need to login in order to purchase any items!!</div>';
					}
		
				?>
					
				</section>

			</div>

			
			<button type="submit" class="floatbtn" onclick="openNav()"><img src="cart.png"></button>
		
		

		
		
			<section id="bill">
				
					<section id="information" style="display:none">
					
						<div class="container">
							<h1>Shipping Information</h1>
							<div class="formone">
							
								<div class="way">
									<h2>Shipping Method<h2>
									<p>If your order is over 30 &euro; you get a free delivery!</p>
									<p>Home delivery is +2 &euro; and Express is +6 &euro;</p>
									<input list="deliverypick" id="delivery" name="deliverypick" autocomplete="off" required>
									<datalist id="deliverypick">
										<option value="Pick up from Store">Pick up from Store</option>
										<option value="Pick up from Delivery Point">Pick up from Delivery Point</option>
										<option value="Home Delivery">Home Delivery</option>
										<option value="Express Home Delivery">Express Home Delivery</option>
									</datalist>
								</div>
								<div class="inf">
									<h2>First Name<h2>
									<input type="text" name="firstname" class="see" placeholder="*Enter Characters Only" required>
								</div>
								<div class="inf">
									<h2>Last Name<h2>
									<input type="text" name="lastname" class="see" placeholder="*Enter Characters Only" required>
								</div>
								<div class="inf">
									<h2>Address<h2>
									<input type="text" name="address" class="see" placeholder="*Enter Characters Only"required>
								</div>
								<div class="inf">
									<h2>Address Number<h2>
									<input type="text" name="addnum"  onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" maxlength="5" autocomplete="off" required>
								</div>
								<div class="inf">
									<h2>ZIP Code<h2>
									<input type="text" name="zipcode"   onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" maxlength="5"  autocomplete="off"required>
								</div>
								<div class="inf">
									<h2>Region<h2>
									<input type="text" name="region" class="see" placeholder="*Enter Characters Only" required>
								</div>
								<div class="inf">
									<h2>Phone Number<h2>
									<input type="tel" name="phonenum" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" maxlength="13" autocomplete="off" required>
								</div>
								<div class="inf">
									<h2>Email<h2>
									<input type="email" name="email" required>
								</div>
								<h4>Remember information for future orders<input type="checkbox"></h4>
								<button type="button" class="previous" id="myBtn" onclick="closeInformation()">Edit Υour Οrder</button>
								<br>
								
								<button type="button" id="myBtn" onclick="validate()">Proceed</button>
								

							</div>
						
							
						</div>
					</section>
					
					
					<section id="buyinformation" style="display:none">
						<h1>Billing Information</h1> 
						<div class="formtow">
						
							<div class="delivery">
								<h2><li>Pay on delivery<input type="radio" name="billway" value="Pay on delivery" onclick="credit()" required></li></h2>
							</div>
							
							<div class="credit_card">
								<h2><li>Credit or Debit Card<input type="radio" name="billway" id="myCheck" value="Credit Card" onclick="credit()" required></li></h2>
								
								<section id="text" style="display:none">
									<div class="credit">
										<img src="mastercard.png"><input type="radio" name="card" value="mastercard" class="visa6" >
									</div>
									<div class="credit">
										<img src="visa.jpg"><input type="radio" name="card" value="visa" class="visa5">
									</div>
									
									<div class="credit" >
										<h3>Card Number:</h3>
										<input type="text" name="cardnum" class="visa" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"  maxlength="16" autocomplete="off" >
									</div>
									<div class="credit">
										<h3>Expiration Date:</h3>
										<input type="month" name="expdate" class="visa2" >
									</div>
									<div class="credit">
										<h3>Secutiry Code:</h3>
										<input type="password" name="code" class="visa3"onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"  maxlength="3" autocomplete="off" >	
									</div>
									<div class="credit">
										<h3>Cardholders Name:</h3>
										<input type="text" name="cardname" class="visa4" >
									</div>
									<h4>Remember this card for future orders<input type="checkbox" ></h4>
								</section>
							
							</div>
							
							<div class="bank_acc">
								<h2><li>Bank Account<input type="radio" name="billway" value="bank account" onclick="credit()" required></li></h2>
							</div>
							
							<h2 class="finalprice">Total Price:</h2>
							
							<input type="text" class="totalitemscart" name="totalitems" style="display:none">
							<input type="text" class="totalitemsprice" name="totalprice" style="display:none">
							
							<button type="button" class="previous" id="myBtn" onclick="closeInformation2()">Edit Shipping Information</button>
							<br>
							<button type="submit" class="final" name="send">Finish Order</button>
						
						</div>
					</section>
				
				
			</section>
		</form> 

		
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
