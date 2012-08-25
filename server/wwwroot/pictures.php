<?php

include_once "error.php";

$sql = mysqli_init() or error("Unable to init mysql");

if(isset($_GET, $_GET["pic_id"])) $pic_id = $_GET["pic_id"];

$sql->real_connect(ini_get("mysql.default_host"), "root") or error("Unable to connect to mysql");
$sql->select_db('chunky') or error("Unable to select chunky db: ".$sql->error);

$query = "SELECT pictures.id AS id, ".
	"users.name AS user, ".
	"pictures.rel_path AS path, ".
	"pictures.question AS question, ".
	"pictures.upload_date AS date ".
	"FROM pictures INNER JOIN users ON users.id=pictures.user_id";
	
if(isset($pic_id))
{
	is_numeric($pic_id) or error("pic_id is not numeric");
	$pic_id = intval($pic_id);
	$pic_id or error("pic_id is not an integer");
	
	$query .= " WHERE pictures.id=$pic_id";
}

$result = $sql->query($query)
	or error("cant read from pictures table: ".$sql->error);
	
($result->num_rows > 0 ) or error("No pictures in db");
	
$message = '{ "result": [';
$id = 0;

while( ($row = $result->fetch_array()) )
{	
	if($id != 0) $message .= ",\n";

	$pic_id = $row['id'];
	$username = $row['user'];
	$path = $row['path'];
	$question = $row['question'];
	$date = $row['date'];
	
	($pic_id && $username && $path && $question) or error("row $id is no good");
	
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

$sql->close();

?>