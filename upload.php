<?php
	
	$file = $_FILES['file'];
	
	$filename = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];
	
	$fileExt = explode('.' , $filename);
	$fileActualExt = strtolower(end($fileExt));
	
	$allowed = array('jpg' , 'jpeg' , 'png');
	
	$date = date("Y-m-d");
	//Change date to dd/mm/yyyy

	
	
	
	if (isset($_SESSION['username'])){
		
		$username = $_SESSION['username'];
	}
	
	if ($filename != "")
	{
	
		if (in_array($fileActualExt, $allowed)) { //Checking if the type of the file is allowed
			
			if($fileError === 0){ //Checking if there are any errors 
				
				if ($fileSize < 500000){ //Checking the files size
				
					$fileNameNew = uniqid('', true).".".$fileActualExt;
					$fileDestionation = 'uploads/'.$fileNameNew;
					
					move_uploaded_file($fileTmpName, $fileDestionation);
					
					$sql = "INSERT INTO reviews ( username , date ,photo) VALUES ('$username' , '$date' , '$fileNameNew')";
					
					if($conn->query($sql)){
						
						echo '<script language="javascript">';
						echo 'alert("Your image has been uploaded successfuly!")';
						echo '</script>';
					
						header("refresh:0.2;url= reviews.php");
						
					}
					else{
						echo '<script language="javascript">';
						echo 'alert("There was an error uploading your file!")';
						echo '</script>';
						
						header("refresh:0.2;url= reviews.php");
					}
					
				}
				else{
					echo '<script language="javascript">';
					echo 'alert("This file is too Big!")';
					echo '</script>';
					
					header("refresh:0.2;url= reviews.php");
				}
			}
			else{
				
				echo '<script language="javascript">';
				echo 'alert("There was an error uploading your file!")';
				echo '</script>';
			
				header("refresh:0.2;url= reviews.php");
			}
		}
		else{
			
			echo '<script language="javascript">';
			echo 'alert("You cannot upload files of this type! Use only jpg, jpeg or png!")';
			echo '</script>';
			
			header("refresh:0.2;url= reviews.php");
		
		
		}
	}
	else{
		
		echo '<script language="javascript">';
		echo 'alert("You havent selected any file to upload!")';
		echo '</script>';
			
		header("refresh:0.2;url= reviews.php");
	
	}
	
?>
