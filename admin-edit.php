<?php

	if (isset($_POST['change-category']) ) {
		
		$categId = $_POST['edit-category-id'];
		$categName = $_POST['edit-category-name'];
		$categPhoto = $_POST['edit-category-photo'];
		$categDescr = $_POST['edit-category-descr'];
		$temp = 0;
		
		if ( $categName != "" ) {
			
			$sql = "UPDATE categories SET name='$categName' WHERE id = '$categId' ";
			if ($conn->query($sql) == TRUE) {
				
				$temp++;
			}
		}
		
		if ( $categPhoto != "" ) { 
			
			$sql2 = "UPDATE categories SET img='$categPhoto' WHERE id = '$categId' ";
			if ($conn->query($sql2) == TRUE) {
				
				$temp++;
			}
		}
		
		if ( $categDescr != "" ) { 
			
			$sql3 = "UPDATE categories SET description='$categDescr' WHERE id = '$categId' ";
			if ($conn->query($sql3) == TRUE) {
				
				$temp++;
			}
		}
		
		if ( $temp > 0 ){
			echo '<script language="javascript">';
			echo 'alert("Changes have been saved succesfully!")';
			echo '</script>';
			header("refresh:0.5;url= adminpage.php");
		}
		else{
			echo '<script language="javascript">';
			echo 'alert("Something went wrong!")';
			echo '</script>';
			header("refresh:0.5;url= adminpage.php");
		}
	}
	
	
	if (isset($_POST['change-item']) ) {
		
		$itemId = $_POST['edit-item-id'];
		$itemCategory = $_POST['edit-item-category'];
		$itemName = $_POST['edit-item-name'];
		$itemPhoto = $_POST['edit-item-photo'];
		$itemPrice = $_POST['edit-item-price'];
		$temp = 0;
		
		if ( $itemName != "" ) {
			
			$sql = "UPDATE items SET name='$itemName' WHERE id = '$itemId' ";
			if ($conn->query($sql) == TRUE) {
				
				$temp++;
			}
		}
		
		if ( $itemCategory != "" ) {
			
			$result = $conn->query("SELECT * FROM categories WHERE id='$itemCategory'");
		
			if ( $result-> num_rows == 0){
				echo '<script language="javascript">';
				echo 'alert("This category does not exist , either pick or insert another one!")';
				echo '</script>';
				
				header("refresh:0.5;url= adminpage.php");
				die();
				
			}
			else{
			
				$sql2 = "UPDATE items SET category_id='$itemCategory' WHERE id = '$itemId' ";
				if ($conn->query($sql2) == TRUE) {
					
					$temp++;
				}
			}
		}
		
		if ( $itemPhoto != "" ) {
			
			$sql3 = "UPDATE items SET image='$itemPhoto' WHERE id = '$itemId' ";
			if ($conn->query($sql3) == TRUE) {
				
				$temp++;
			}
		}
		
		if ( $itemPrice != "" ) {
			
			$sql4 = "UPDATE items SET price='$itemPrice' WHERE id = '$itemId' ";
			if ($conn->query($sql4) == TRUE) {
				
				$temp++;
			}
		}
		
		if ( $temp > 0 ){
			echo '<script language="javascript">';
			echo 'alert("Changes have been saved succesfully!")';
			echo '</script>';
			
			header("refresh:0.5;url= adminpage.php");
		}
		else{
			echo '<script language="javascript">';
			echo 'alert("Something went wrong!")';
			echo '</script>';
			
			header("refresh:0.5;url= adminpage.php");
		}
		
	}
	
	
	if (isset($_POST['add-category']) ) {
		
		$name = $_POST['add-category-name'];
		$photo = $_POST['add-category-photo'];
		$descr = $_POST['add-category-descr'];
		
		$sql = "INSERT INTO categories (name, img, description) " . "VALUES ('$name' , '$photo' , '$descr')";
		
		if ( $conn->query($sql) ) {
			echo '<script language="javascript">';
			echo 'alert("New category has been added succesfully!")';
			echo '</script>';
		}
		else{
			echo '<script language="javascript">';
			echo 'alert("Something went wrong , try again!")';
			echo '</script>';
		}
	}
	
	
	if (isset($_POST['add-item']) ) {
		
		$name = $_POST['add-item-name'];
		$photo = $_POST['add-item-photo'];
		$category = $_POST['add-item-category'];
		$price = $_POST['add-item-price'];
		
		$result = $conn->query("SELECT * FROM categories WHERE id='$category'");
		
		if ( $result-> num_rows == 0){
			echo '<script language="javascript">';
			echo 'alert("This category does not exist , either pick or insert another one!")';
			echo '</script>';
			
			header("refresh:0.5;url= adminpage.php");
			
		}
		else{
			$sql = "INSERT INTO items (category_id , name, image, price) " . "VALUES ('$category' , '$name' , '$photo' , '$price')";
			
			if ( $conn->query($sql) ) {
				
				echo '<script language="javascript">';
				echo 'alert("New item has been added succesfully!")';
				echo '</script>';
				
				header("refresh:0.5;url= adminpage.php");
			}
			else{
				echo '<script language="javascript">';
				echo 'alert("Something went wrong , try again!")';
				echo '</script>';
				
				header("refresh:0.5;url= adminpage.php");
			}
		}
	}
	
	if (isset($_POST['delete-category']) ) {
							
		$deletedCategory = $_POST['deleted-category-id'];
								
		echo '<script language="javascript">';
		echo 'confirm("Are you sure?")';
		echo '</script>';
								
		$sql = "DELETE FROM categories WHERE id = '$deletedCategory' ";
				
		if ($conn->query($sql) == TRUE){
			echo '<script language="javascript">';
			echo 'alert("Deleted Succesfully")';
			echo '</script>';
					
			header("refresh:0.5;url= adminpage.php");
		}
		else{
			echo '<script language="javascript">';
			echo 'alert("Something went wrong!")';
			echo '</script>';
					
			header("refresh:0.5;url= adminpage.php");
			}
	}
	
	if (isset($_POST['delete-item']) ) {
							
		$deletedItem = $_POST['deleted-item-id'];
								
		echo '<script language="javascript">';
		echo 'confirm("Are you sure?")';
		echo '</script>';
								
		$sql = "DELETE FROM items WHERE id = '$deletedItem' ";
				
		if ($conn->query($sql) == TRUE){
			echo '<script language="javascript">';
			echo 'alert("Deleted Succesfully")';
			echo '</script>';
					
			header("refresh:0.5;url= adminpage.php");
		}
		else{
			echo '<script language="javascript">';
			echo 'alert("Something went wrong!")';
			echo '</script>';
					
			header("refresh:0.5;url= adminpage.php");
		}
	}




?>