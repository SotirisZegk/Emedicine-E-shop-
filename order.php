<?php
	

	function randomOrderId() {
		$alphabet = '1234567890';
		$order = array(); 
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 6; $i++) {
			$n = rand(0, $alphaLength);
			$order[] = $alphabet[$n];
		}
		return implode($order);
	}	//turn the array into a string
	
	
	$orderId = randomOrderId();
	
	$username = $_SESSION['username'];
	$deliverytype = $_POST['deliverypick'];
	$firstname = $conn->escape_string($_POST['firstname']);
	$lastname = $conn->escape_string($_POST['lastname']);
	$address = $conn->escape_string($_POST['address']);
	$addnum = $conn->escape_string($_POST['addnum']);
	$zipcode = $conn->escape_string($_POST['zipcode']);
	$region = $conn->escape_string($_POST['region']);
	$phone = $conn->escape_string($_POST['phonenum']);
	$email = $conn->escape_string($_POST['email']);
	$totalitems = $conn->escape_string($_POST['totalitems']);
	$totalprice = $conn->escape_string($_POST['totalprice']);
	$paytype = $_POST['billway'];
	$date = date("Y-m-d");
		
	//Checking if an order with the same orderId already exists
	$result = $conn->query("SELECT * FROM orders WHERE orderid='$orderId'") or die($mysqli->error());
	
	if ($result->num_rows > 0 ) {
		
		$orderId = $randomOrderId();
		
	}
	
	
	//INSERT VALUES
	$sql = "INSERT INTO orders (orderid, date, username, firstname, lastname, address, addressnum,
								zipcode, region, phone, email, totalitems, totalprice, deliverytype, paytype) "
	. "VALUES ('$orderId' , '$date' , '$username', '$firstname' , '$lastname', '$address', '$addnum', '$zipcode',
	'$region', '$phone', '$email', '$totalitems', '$totalprice', '$deliverytype', '$paytype')";
	
	//If it happens succesfully
	if ( $conn->query($sql) ) {
	
		echo '<script language="javascript">';
		echo 'alert("Your order has been completed succesfully!")';
		echo '</script>';
		
		header("refresh:0.1;url= main.php");
	}
	else{
		echo '<script language="javascript">';
		echo 'alert("Something went wrong! , Please try again!")';
		echo '</script>';
	
		header("refresh:0.1;url= categories.php");
	
	}
	
	$bought_items = $_POST['order-item-name'];
	$array_length = count($bought_items);
	$temp = 0;
	
	for ( $i = 0; $i < $array_length; $i++){
		
		$itemname = $_POST['order-item-name'][$i];
		$itemphoto = $_POST['order-item-photo'][$i];
		$itemammount = $_POST['order-item-ammount'][$i];
		$itemprice = $_POST['order-item-price'][$i];
		
		
		$sql2 = "INSERT INTO boughtitems (itemorderid, itemname, itemquantity, itemphoto, itemprice) "
		. "VALUES ('$orderId' , '$itemname' , '$itemammount', '$itemphoto' , '$itemprice')";
		
		if ( $conn->query($sql2) ) {
	
			$temp++;
		
		}
		
	}
	
	if ( $temp != $array_length ){
		
		echo '<script language="javascript">';
		echo 'alert("Something went wrong!")';
		echo '</script>';
	}
	

?>





