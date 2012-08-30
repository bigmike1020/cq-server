<?php 

include_once "util.php";

$_POST or error("No POST");

$sql = new sqldb()
  or error("Unable to init mysql");

$username = $sql->escape_string($_POST["username"])
  or "Anon";
$username = trim($username);
$question = $sql->escape_string($_POST["question"]) 
  or error("Need a question");
$question = trim($question);
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

// drop images over 1 MB
(strlen($image) < (1024*1024))
  or error("Image is too big!");
  
// validate it really is an image
$finfo = finfo_open(FILEINFO_MIME_TYPE)
  or error("cant open file info object");
$info = finfo_buffer($finfo, $image)
  or error("cant read image info");

strpos(' '.$info, 'image') // space char so offset>0 on match
  or error("File is not an image, it's a $info!");

finfo_close($finfo);

// save image to file
saveImage($image, $dir.$filename);

$userid = getUserId($sql, $username)
	or error("cant find userid");

$sql->query("INSERT INTO tPictures (cUser_id, cRel_path, cQuestion) VALUES ('$userid', '$filename', '$question')")
	or error("cant insert into pictures");
	
$id = $sql->insert_id()
  or error("error inserting into db");

$message = '{ '.
	"\"result\":$id".
'}';

echo $message;

// remove old images
$maxImage = 100;

$result = $sql->query("SELECT cRel_path FROM tPictures ORDER BY cUpload_date DESC LIMIT $maxImage,-1");

while( ($row = $result->fetchArray()) )
{
  $filename = $row['cRel_path'];
  $sql->exec("DELETE FROM tPictures WHERE cRel_path='$filename'");
  unlink($dir.$filename);
}

// remove unused users and answers
$select_ids = "SELECT cId FROM tPictures";
$sql->exec("DELETE FROM tUsers WHERE cId NOT IN (SELECT cUser_id FROM tPictures UNION SELECT cUser_id FROM tAnswers)");
$sql->exec("DELETE FROM tAnswers WHERE cId NOT IN (SELECT cPicture_id FROM tAnswers)");

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
