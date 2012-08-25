<?php 

// filename: upload.php 

include_once "error.php";

$baseDir = "images/";

// make a unique filename for the uploaded file and check it is not already 
// taken... if it is already taken keep trying until we find a vacant one 
// sample filename: 1140732936-filename.jpg 
$now = time(); 
$uploadFilename = $baseDir.$now.basename( $_FILES['file']['name']);
while(file_exists($uploadFilename)) 
{ 
    $now++; 
	$uploadFilename = $baseDir.$now . basename( $_FILES['file']['name']);
} 

if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilename)) {

} else{
	error("Unable to move uploaded file");
}

?>