<?php

$sql = mysqli_init() or error("Unable to init mysql");

$sql->real_connect(ini_get("mysql.default_host"), "root") or error("Unable to connect to mysql");
$sql->select_db('chunky') or error("Unable to select chunky db: ".$sql->error);

$result = $sql->query("SELECT pictures.id AS id, ".
	"users.name AS user, ".
	"pictures.rel_path AS path, ".
	"pictures.question AS question, ".
	"pictures.upload_date AS date ".
	"FROM pictures INNER JOIN users ON users.id=pictures.user_id") or error("cant read from pictures table: ".$sql->error);
	
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

exit;



// The following function is an error handler which is used 
// to output an HTML error page if the file upload fails 
function error($error, $seconds = 5) 
{ 
    echo '{'.
	"\"error\": \"$error\"".
	'}';
    exit; 
} // end error handler 

?>