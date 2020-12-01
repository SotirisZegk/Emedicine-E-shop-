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
				if (isset($_POST['submit-comment'])) {
					
					$username = $_SESSION['username'];
					$reviewId = $_SESSION['review-id'];
					$comment = $_POST['users-comment'];
					
					$sql = "INSERT INTO comments ( reviewid , username , comment) VALUES ('$reviewId' , '$username' , '$comment')";
					
					if($conn->query($sql)){
						
						echo '<script language="javascript">';
						echo 'alert("Your comment has beeen submited successfuly!")';
						echo '</script>';
					
						header("refresh:0.1;url= itemreview.php");
						
					}
					else{
						echo '<script language="javascript">';
						echo 'alert("There was an error!")';
						echo '</script>';
						
						header("refresh:0.1;url= itemreview.php");
					}
					
				}
				elseif (isset($_POST['submit-rating']))
				{
					$username = $_SESSION['username'];
					$reviewId = $_SESSION['review-id'];
					$rate = $_POST['users-rating'];
					
					$sql = "INSERT INTO rating ( reviewid , username , rate) VALUES ('$reviewId' , '$username' , '$rate')";
					
					if($conn->query($sql)){
						
						echo '<script language="javascript">';
						echo 'alert("Your rating has beeen submited successfuly!")';
						echo '</script>';
					
						header("refresh:0.1;url= itemreview.php");
						
					}
					else{
						echo '<script language="javascript">';
						echo 'alert("There was an error!")';
						echo '</script>';
						
						header("refresh:0.1;url= itemreview.php");
					}
					
				}
			}
		?>
		
		<section id="photoreview">
			<div class="container">
			
				<?php 
			
					if ($_SERVER['REQUEST_METHOD'] == 'POST')
					{
						if (isset($_POST['photo-id'])) {
							$tempor = $_POST['photo-id'];
							$_SESSION['review-id'] = $tempor;
						}
					}
					$itemid = $_SESSION['review-id'];
					$iteminfo = $conn->query("SELECT * FROM reviews WHERE id = '$itemid'");
					$stars = $conn->query("SELECT * FROM rating WHERE reviewid = '$itemid'");
					$comments = $conn->query("SELECT * FROM comments WHERE reviewid = '$itemid'");
			
					$totalrates = 0;
					$ratesum = 0;
					$finalrating = 0 ;
					
					$item = $iteminfo->fetch_assoc();
					
					while ($star = $stars->fetch_assoc()) //Checks the ammount of rating in each picture and sums it up
					{
						$ratesum = $ratesum + $star['rate'];
						$totalrates++;
					}
					
					if ($totalrates != 0){ //Checks if we have at least one rating
						
						$finalrating = $ratesum / $totalrates;
					}
					
					$finalrating = round($finalrating , 2);  //Rounds it up to 2 demicals
						
					echo	'<div class="left-side">';
					echo		'<p class="reviewer"><img src="profile.png">'.$item['username'].'<span class="date">'.$item['date'].'</span></p>';
					echo		'<img class="item-img" src="uploads/'.$item['photo'].'">';
					echo		'<br>';
					echo		'<span class="rating"><img src="star.png"> '.$finalrating.' <span class="totalstars"> ('.$totalrates.') </span></span>';
					echo 	'</div>';
					
				?>
					
					<div class="right-side">
						<form action="itemreview.php" class="add-comment" method="post">
							<p>Add a comment:</p>
							<input type="text" name="users-comment" required>
							<button type="submit" class="submit-com" name="submit-comment" <?php if(empty($_SESSION['logged_in'])) { ?> disabled <?php } ?>>Submit Comment</button>
							
						</form>
						
						<?php 
							if (empty($_SESSION["logged_in"])){
								echo '<div class="unable">You need to login in order to submit a comment or a rating!</div>';
							}
						?>
						
					
						<form action="itemreview.php" class="add-rating" method="post">
							<span>You can rate this item</span>
							<img src="star.png">
							<span class="submit-rate"><input type="number" value="5" min="1" max="5" name="users-rating" required>
							<button name="submit-rating" <?php if(empty($_SESSION['logged_in'])) { ?> disabled <?php } ?>>Rate</button></span>
							
						</form>
					</div>
					
					
				<?php
				
					if ($_SERVER['REQUEST_METHOD'] == 'POST')
					{
						if (isset($_POST['photo-id'])) {
							$tempor = $_POST['photo-id'];
							$_SESSION['review-id'] = $tempor;
						}
					}
					
					$itemid = $_SESSION['review-id'];
					$comments_ammount = $conn->query("SELECT * FROM comments WHERE reviewid = '$itemid'");
					$totalcomms = 0;
				
					while ($comms = $comments_ammount->fetch_assoc()) //Sums up the ammount of total comments
					{
						$totalcomms++;
					}
				
					echo	'<div class="comment-section">';
					echo		'<div class="comment-ammount">';
					echo			'<img src="comments.png">'.$totalcomms.' Comments';
					echo		'</div>';
					while ($comm = $comments->fetch_assoc())
					{
						echo '<div class="comment"><img src="profile.png"> '.$comm['username'].' : '.$comm['comment'].'</div>';
						$totalcomms++;
					}
					echo 	'</div>';
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