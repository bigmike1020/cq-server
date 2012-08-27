<?php

include_once "util.php";

$sql = new sqldb()
  or error("Unable to init mysql");

$query = "SELECT tPictures.cId AS id, ".
	"tUsers.cName AS user, ".
	"tPictures.cRel_path AS path, ".
	"tPictures.cQuestion AS question, ".
	"tPictures.cUpload_date AS date ".
	"FROM tPictures INNER JOIN tUsers ON tUsers.cId=tPictures.cUser_id ".
	"ORDER BY tPictures.cUpload_date DESC";

if(isset($_GET, $_GET["pic_id"])) $pic_id = $_GET["pic_id"];

if(isset($pic_id))
{
	is_numeric($pic_id) 
    or error("pic_id is not numeric");
	$pic_id = intval($pic_id)
    or error("pic_id cannot be 0");
	
	$query .= " WHERE pictures.id=$pic_id";
}

$result = $sql->query($query)
	or error("cant read from pictures table: ".$sql->error());
	
$message = '{ "result": [';
$id = 0;

while( ($row = $result->fetch()) )
{	
	if($id != 0) $message .= ",\n";

	$pic_id = $row['id'];
	$username = $row['user'];
	$path = $row['path'];
	$question = $row['question'] or "";
	$date = $row['date'];
	
	($pic_id && $username && $path) or error("row $id is no good");
	
	$message .= "{".
		"\"pic_id\":\"$pic_id\",".
		"\"user\":\"$username\",".
		"\"path\":\"$path\",".
		"\"question\":\"$question\",".
		"\"date\":\"$date\"".
	"}";
	++$id;
}
$message .= '] }';

echo $message;

?>
