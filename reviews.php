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
				if (isset($_POST['upload'])) {
					require 'upload.php';
				}
			}
		?>
		
		<section id="userreviews">
			<div class="container">
				<h1>Item-Reviews</h1>
				
				<?php 
					
					if(empty($_SESSION['logged_in'])) 
					{
						echo '<h3 class="unable">You need to login in order to upload any files!</h3>';
					}
					else{
						echo "<h3>You can upload pictures now</h3>";
					}
				?>
				
				<form action="reviews.php" method="POST" enctype="multipart/form-data">
					<input type="file" name="file" <?php if(empty($_SESSION['logged_in'])) { ?> disabled <?php } ?>>
					<br>
					<button type="submit" name="upload" class="upload-img" <?php if(empty($_SESSION['logged_in'])) { ?> disabled <?php } ?>>UPLOAD IMAGE</button>
				</form>	
				
				<?php 
					
					$result = $conn->query("SELECT * FROM reviews");
					if( $result-> num_rows == 0){
						echo "<div class='empty'>There are no images right now!</div>";

					}
					else
					{
						while ($review = $result->fetch_assoc())
						{
							
							$reviewId = $review['id'];
							
							$stars = $conn->query("SELECT * FROM rating WHERE reviewid = '$reviewId'");
							$comment = $conn->query("SELECT * FROM comments WHERE reviewid = '$reviewId'");
							
							$totalrates = 0;
							$totalcomms = 0;
							$ratesum = 0;
							
							while ($star = $stars->fetch_assoc()) //Checks the ammount of rating in each picture and sums it up
							{
								$ratesum = $ratesum + $star['rate'];
								$totalrates++;
							}
							while ($comm = $comment->fetch_assoc()) //Checks the ammount of comments in each picture
							{
								$totalcomms++;
							}
							
							$finalrating = 0 ;
							
							if ($totalrates != 0){ //Checks if we have at least one rating
								
								$finalrating = $ratesum / $totalrates;
							}
						
							$finalrating = round($finalrating , 2); //rounds our rating in up to 2 demicals
					
							echo 	'<form action="itemreview.php" method="post">';
							echo		'<div class="review">';
							echo			'<p class="user-title"><img src="profile.png">'.$review['username']. '<span class="date"> '.$review['date'].'</span></p>';
							echo			'<button class="item-frame" name="photo-id" value='.$reviewId.'><img class="item-img" src="uploads/'.$review['photo'].'"></button>';
							echo			'<br>';
							echo			'<span class="stars"><img src="star.png"> '.$finalrating.' <span class="totalstars"> ('.$totalrates.')</span></span>';
							echo			'<span class="comments"><img src="comments.png">'.$totalcomms.'</span>';
							echo 			'<input type="text"  name="finalrating" value='.$finalrating.' style="display:none">';
							echo 			'<input type="text"  name="totalcomments" value='.$totalcomms.' style="display:none">';
							echo 			'<input type="text"	 name="totalrates" value='.$totalrates.' style="display:none">';
							echo		'</div>';
							echo	'</form>';
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
	
	