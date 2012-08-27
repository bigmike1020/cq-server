<?php 

include_once "util.php";

$_POST or error("No POST");

$sql = new sqldb()
  or error("Unable to init mysql");

$username = $sql->escape_string($_POST["username"]) 
  or "Anonymous";
$question = $sql->escape_string($_POST["question"]) 
  or error("Need a question");
$fileBase64 = $_POST["file"] 
  or error("need an image");

// make a note of the directory that will recieve the uploaded file 
$dir = 'images/';

// Now let's deal with the upload 
     
// make a unique filename for the uploaded file and check it is not already 
// taken... if it is already taken keep trying until we find a vacant one 
// sample filename: 1140732936-filename.jpg 
do
{
  $filename = uniqid('pic_').'.jpeg';
} while(file_exists($dir.$filename));

// decode the image
$image = base64_decode($fileBase64);
getimagesizefromstring($image)
  or error("Not a valid image");

// save image to file
saveImage($image, $dir.$filename);

$userid = getUserId($sql, $username)
	or error("cant find userid");

$sql->query("INSERT INTO pictures (user_id, rel_path, question) VALUES ('$userid', '$uploadFilename', '$question')")
	or error("cant insert into pictures");
	
$id = $sql->insert_id 
  or error("error inserting into db");

$message = '{ '.
	"\"result\":$id".
'}';

echo $message;

function saveImage($image, $name)
{
  isset($image, $name)
    or error("No image or filename");
  
  $fp = fopen($name, 'w')
    or error("Cant open file for writing");
  
  fwrite($fp, $image)
    or error ("Cant write image to file");
  
  fclose($fp);
}

?>