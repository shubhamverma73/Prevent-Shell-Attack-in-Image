<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<?php
function is_valid_file($file) { 
	$uploaded_name = $file[ 'name' ];
	$uploaded_ext  = substr( $uploaded_name, strrpos( $uploaded_name, '.' ) + 1); 
	$uploaded_size = $file[ 'size' ]; 
	$uploaded_type = $file[ 'type' ]; 
	$uploaded_tmp  = $file[ 'tmp_name' ]; 

	// Where are we going to be writing to? 
	$target_file   =  md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext; 
	$temp_file     = ( ( ini_get( 'upload_tmp_dir' ) == '' ) ? ( sys_get_temp_dir() ) : ( ini_get( 'upload_tmp_dir' ) ) ); 
	$temp_file    .= DIRECTORY_SEPARATOR . md5( uniqid() . $uploaded_name ) . '.' . $uploaded_ext;
	
	// Is it an image? 
	if( ( strtolower( $uploaded_ext ) == 'jpg' || strtolower( $uploaded_ext ) == 'jpeg' || strtolower( $uploaded_ext ) == 'png' ) && ( $uploaded_size < 100000 ) && ( $uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png' ) && getimagesize( $uploaded_tmp ) ) { 
		
		// Strip any metadata, by re-encoding image (Note, using php-Imagick is recommended over php-GD) 
		if( $uploaded_type == 'image/jpeg' ) { 							
			$img = imagecreatefromjpeg( $uploaded_tmp ); 
			imagejpeg( $img, $temp_file, 100); 
		} else { 
			$img = imagecreatefrompng( $uploaded_tmp ); 
			imagepng( $img, $temp_file, 9); 
		} 
		imagedestroy( $img ); 
		return true;
	} else { 
		// Invalid file 
		return false; 
	}
}
?>