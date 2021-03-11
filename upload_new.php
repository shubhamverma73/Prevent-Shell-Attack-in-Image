<?php 
include('file_validation.php');

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["uploaded"]["name"]);

if(isset($_POST["Upload"])) {

	echo is_valid_file($_FILES["uploaded"]); exit();

	if (move_uploaded_file($_FILES["uploaded"]["tmp_name"], $target_file)) {
		echo "The file ". htmlspecialchars( basename( $_FILES["uploaded"]["name"])). " has been uploaded.";
	} else {
		echo "Sorry, there was an error uploading your file.";
	}
}

?> 