<?php

include_once "util.php";

$sql = new sqldb()
  or error("Unable to init mysql");

$query = "SELECT pictures.id AS id, ".
	"users.name AS user, ".
	"pictures.rel_path AS path, ".
	"pictures.question AS question, ".
	"pictures.upload_date AS date ".
	"FROM pictures INNER JOIN users ON users.id=pictures.user_id ".
	"ORDER BY pictures.upload_date DESC";

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
	or error("cant read from pictures table: ".$sql->error);
	
$message = '{ "result": [';
$id = 0;

while( ($row = $result->fetchArray()) )
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