<?php 
include('file_validation.php');

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["uploaded"]["name"]);

if(isset($_POST["Upload"])) {

	$is_valid_file = is_valid_file($_FILES["uploaded"]);

	if($is_valid_file == true) {
		if (move_uploaded_file($_FILES["uploaded"]["tmp_name"], $target_file)) {
			echo "<pre>The file ". htmlspecialchars( basename( $_FILES["uploaded"]["name"])). " has been uploaded.</pre>";
		} else {
			echo "<pre>Sorry, there was an error uploading your file.</pre>";
		}
	} else {
		echo '<pre>We can only accept JPEG or PNG images.</pre>';
	}
}
?> 