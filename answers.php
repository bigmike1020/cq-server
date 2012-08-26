<?php

include_once "util.php";
use util\error;

isset($_GET) or error("No _GET");

$pic_id = $_GET["pic_id"] 
  or error("need a pic_id");

is_numeric($pic_id) 
  or error("pic_id is not numeric");
$pic_id = intval($pic_id);
$pic_id 
  or error("pic_id is not an integer");

$sql = new util\sqldb() 
  or error("Unable to init sql");

$result = $sql->query("SELECT answers.answer AS answer, ".
	"users.name AS user, ".
	"answers.date AS date ".
	"FROM answers INNER JOIN users ON users.id=answers.user_id ".
  "WHERE answers.picture_id=".$pic_id." ".
	"ORDER BY answers.date DESC")
	or error("cant read from answers table: ".$sql->error);
	
$message = '{ "result": [';
$id = 0;

while( ($row = $result->fetchArray()) )
{	
	if($id != 0) $message .= ",\n";

	$answer = $row['answer'];
	$user = $row['user'];
	$date = $row['date'];
	
	($answer && $user && $date)
    or error("row $id is no good");
	
	$message .= "{".
		"\"answer\":\"$answer\",".
		"\"user\":\"$user\",".
		"\"date\":\"$date\"".
	"}";
	++$id;
}
$message .= '] }';

echo $message;

?>