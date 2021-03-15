<?php
session_start();

function generateSessionToken() {
	$data['_token'] = md5(uniqid(rand(), true));
	$_SESSION['_token'] = $data['_token'];
}
generateSessionToken(); 
?> 
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Bootstrap Example</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
	    <div class="row">
			<p>&nbsp;</p>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading text-center"><b>Secure Image Upload System</b></div>
				<div class="panel-body">
					<form enctype="multipart/form-data" action="upload_new.php" method="POST">
						<div class="form-group">
							<label for="email">Choose an image to upload:</label>
							<input name="uploaded" type="file" >
						</div>
						<input type="hidden" name="_token"  value="<?php echo $_SESSION['_token']; ?>" />
						<button type="submit" name="Upload" class="btn btn-success btn-block">Upload</button>
					</form>
				</div>
			</div>
		</div>
	  </div>
	</div>
</body>
</html>
