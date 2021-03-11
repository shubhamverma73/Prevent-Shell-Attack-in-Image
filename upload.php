<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<?php
session_start();

function generateSessionToken() {
	$data['_token'] = md5(uniqid(rand(), true));
	$_SESSION['_token'] = $data['_token'];
}

if( isset( $_POST[ 'Upload' ] ) ) { 
	// Check Anti-CSRF token 
    if ($_POST['_token'] === $_SESSION['_token']) {
		// File information 
		$uploaded_name = $_FILES[ 'uploaded' ][ 'name' ]; 
		$uploaded_ext  = substr( $uploaded_name, strrpos( $uploaded_name, '.' ) + 1); 
		$uploaded_size = $_FILES[ 'uploaded' ][ 'size' ]; 
		$uploaded_type = $_FILES[ 'uploaded' ][ 'type' ]; 
		$uploaded_tmp  = $_FILES[ 'uploaded' ][ 'tmp_name' ]; 

		// Where are we going to be writing to? 
		$target_path   = 'uploads/'; 
		$target_file   =  md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext; 
		$temp_file     = ( ( ini_get( 'upload_tmp_dir' ) == '' ) ? ( sys_get_temp_dir() ) : ( ini_get( 'upload_tmp_dir' ) ) ); 
		$temp_file    .= DIRECTORY_SEPARATOR . md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
		
		// Is it an image? 
		if( ( strtolower( $uploaded_ext ) == 'jpg' || strtolower( $uploaded_ext ) == 'jpeg' || strtolower( $uploaded_ext ) == 'png' ) && 
			( $uploaded_size < 100000 ) && 
			( $uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png' ) && 
			getimagesize( $uploaded_tmp ) ) { 
			
			// Strip any metadata, by re-encoding image (Note, using php-Imagick is recommended over php-GD) 
			if( $uploaded_type == 'image/jpeg' ) { 
							
				$img = imagecreatefromjpeg( $uploaded_tmp ); 
				imagejpeg( $img, $temp_file, 100); 
			} else { 
				$img = imagecreatefrompng( $uploaded_tmp ); 
				imagepng( $img, $temp_file, 9); 
			} 
			imagedestroy( $img ); 

			// Can we move the file to the web root from the temp folder? 
			if( rename( $temp_file, ( getcwd() . DIRECTORY_SEPARATOR . $target_path . $target_file ) ) ) { 
				// Yes! 
				$target = getcwd() . DIRECTORY_SEPARATOR . $target_path . $target_file;
				echo "<pre><a href='${target_path}${target_file}'>${target_file}</a> succesfully uploaded!</pre>"; 
			} else { 
				// No 
				echo '<pre>Your image was not uploaded.</pre>'; 
			}
			// Delete any temp files 
			if( file_exists( $temp_file ) ) 
				unlink( $temp_file ); 
		} else { 
			// Invalid file 
			echo '<pre>Your image was not uploaded. We can only accept JPEG or PNG images.</pre>'; 
		} 		
	} else {
		die("CSRF TOKEN MATCH FAILED!...");
	}
}
generateSessionToken(); 
?>