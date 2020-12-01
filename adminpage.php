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
		<?php
			if (empty($_SESSION['admin-login']) ) {
				echo '<script language="javascript">';
				echo 'alert("You need to login as an admin in order to view this page")';
				echo '</script>';
				
				header("refresh:0.5;url= adminlogin.php");
			}
		?>
		
		<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if (isset($_POST['change-category']) || isset($_POST['change-item']) || isset($_POST['add-category']) || 
				isset($_POST['add-item']) || isset($_POST['delete-category']) || isset($_POST['delete-item']) ) {
						
					require 'admin-edit.php';
				}

			}
		?> 
		
		
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
							if(isset($_SESSION['admin-login'])) {
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
		
		
		
		

		<section id="admin-main">
		
			<div class="admin-categories">
			
				<h1>Current Categories</h1>
				<div class="categories-row">
					<span class="catid">ID</span>
					<span class="catname">Name</span>
					<span class="catphoto">Photo</span>
					<span class="catdescr">Description</span>
				</div>
				
				
				<?php 
					
					$result = $conn->query("SELECT * FROM categories");
					
					if( $result-> num_rows == 0){
						
						echo '<div class="empty">No available categories right now</div>';

					}
					
					while  ( $category  = $result->fetch_assoc() ) {
						
						echo	'<div class="admin-category">';
						echo		'<input type="text" class="hidden-id" value="'.$category['id'].'" style="display:none">';
						echo		'<span class="category-id">'.$category['id'].'</span>';
						echo		'<span class="category-title">'.$category['name'].'</span>';
						echo		'<span class="category-img">'.$category['img'].'</span>';
						$descr = $category['description'];  
						$pos=strpos($descr, ' ', 50);
						$x = substr($descr,0,$pos ); //SHOWS A ONLY A SPECIFIC AMMOUNT OF THE DESCRIPTION
						echo 		'<span class="category-descr">'.$x.'....</span>';
						echo		'<span><button type="button" class="edit" name="edit-ctg" onclick="popup()">Edit</button></span>';
						echo		'<form action="adminpage.php" method="post">';
						echo			'<input type="text" name="deleted-category-id" value="'.$category['id'].'" style="display:none">';
						echo			'<span><button class="delete" name="delete-category">Delete</button></span>';
						echo		'</form>';
						echo 	'</div>';
			
					}
					
				?>
				<div class="add">
					<button type="button" onclick="popup3()" class="add-categ">ADD CATEGORY</button>
				</div>
				
			</div>
			
			
			<div class="admin-items">
				<h1>Current Items</h1>
				
				<div class="item-row">
					<span>Name</span>
					<span>Category</span>
					<span>Photo</span>
					<span>Price</span>
				</div>
				
				<?php 
					
					$result = $conn->query("SELECT * FROM items");
					
					if( $result-> num_rows == 0){
						
						echo '<div class="empty">No available items right now</div>';

					}
					
					while  ( $item  = $result->fetch_assoc() ) {
						
						echo 	'<div class="admin-item">';
						echo		'<span class="item-name">'.$item['name'].'</span>';
						echo		'<input type="text" class="hidden-item-id" value="'.$item['id'].'" style="display:none">';
						
						$categ_item = $item['category_id'];
						$result2 = $conn->query("SELECT * FROM categories WHERE id = '$categ_item' ");
						while ( $category = $result2->fetch_assoc() ) {
							echo 	'<span class="item-categ">'.$category['name'].'</span>';
						}
						echo		'<span class="item-img">'.$item['image'].'</span>';
						echo		'<span class="item-price">'.$item['price'].' &euro;</span>';
						echo		'<span><button class="edit" name="edit-itm" onclick="popup2()">Edit</button></span>';
						echo		'<form action="adminpage.php" method="post">';
						echo			'<input type="text" name="deleted-item-id" value="'.$item['id'].'" style="display:none">';
						echo			'<span><button class="delete" name="delete-item">Delete</button></span>';
						echo		'</form>';
						echo	'</div>';
					}
					
				?>
				
				<div class="add">
					<button type="button" onclick="popup4()" class="add-categ">ADD A NEW ITEM</button>
				</div>
				
			</div>
			
		</section>
		
		<form class="admin-edit" id="edit-category" style="display:none" method="post" action="adminpage.php">
			<div class="contains">
				<button type="button" class="close" onclick="popup()">+</button>
				<h1>Edit Category</h1>
				<input type="text" name="edit-category-id" style="display:none">
				<input type="text" name="edit-category-name" placeholder="Enter new Category name">
				<input type="text" name="edit-category-photo" placeholder="Enter the link for the new Image">
				<input type="text" name="edit-category-descr" placeholder="Enter new Category Description" class="description">
				<br>
				<p>If you dont want to change something , just leave it blank!</p>
				<button type="submit" name="change-category" class="change">Submit</button>
			</div>
		</form>
		
		<form class="admin-edit" id="edit-item" style="display:none" method="post" action="adminpage.php">
			<div class="contains">
				<button type="button" class="close" onclick="popup2()">+</button>
				<h1>Edit Item</h1>
				<input type="text" name="edit-item-id" style="display:none">
				<input type="text" name="edit-item-name" placeholder="Enter new Item name">
				<input type="text" name="edit-item-category" placeholder="Enter the Category of the Image">
				<input type="text" name="edit-item-photo" placeholder="Enter the link of the new photo">
				<input type="text" name="edit-item-price" placeholder="Enter the new Price">
				<br>
				<p>If you dont want to change something , just leave it blank!</p>
				<button type="submit" name="change-item" class="change">Submit</button>
			</div>
		</form>
		
		<form class="admin-edit" id="admin-add-category" style="display:none" method="post" action="adminpage.php">
			<div class="contains">
				<button type="button" class="close" onclick="popup3()">+</button>
				<h1>Add Category</h1>
				<input type="text" name="add-category-name" placeholder="Enter Category name" required>
				<input type="text" name="add-category-photo" placeholder="Enter the link for the image" required>
				<input type="text" name="add-category-descr" placeholder="Enter Category Description" class="description" required>
				<br>
				<button type="submit" name="add-category" class="change">Submit</button>
			</div>
		</form>
		
		<form class="admin-edit"  id="admin-add-item" style="display:none" method="post" action="adminpage.php">
			<div class="contains">
				<button type="button" class="close" onclick="popup4()">+</button>
				<h1>Add Item</h1>
				<input type="text" name="add-item-name" placeholder="Enter Item name" required>
				<input type="text" name="add-item-category" placeholder="Enter the Category of the item" required>
				<input type="text" name="add-item-photo" placeholder="Enter the link for the Image" required>
				<input type="text" name="add-item-price" placeholder="Enter the the Price" required>
				<br>
				<button type="submit" name="add-item" class="change">Submit</button>
			</div>
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
