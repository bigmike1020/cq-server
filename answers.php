<?php

include_once "util.php";

isset($_GET) or error("No _GET");

$pic_id = $_GET["pic_id"] 
  or error("need a pic_id");

is_numeric($pic_id) 
  or error("pic_id is not numeric");
$pic_id = intval($pic_id);
$pic_id 
  or error("pic_id is not an integer");

$sql = new sqldb() 
  or error("Unable to init sql");

$result = $sql->query("SELECT tAnswers.cAnswer AS answer, ".
	"tUsers.cName AS user, ".
	"tAnswers.cDate AS date ".
	"FROM tAnswers INNER JOIN tUsers ON tUsers.cId=tAnswers.cUser_id ".
  "WHERE tAnswers.cPicture_id=".$pic_id." ".
	"ORDER BY tAnswers.cDate DESC")
	or error("cant read from answers table: ".$sql->error());
	
$message = '{ "result": [';
$id = 0;

while( ($row = $result->fetch()) )
{	
	if($id != 0) $message .= ",\n";

	$answer = $row['answer'];
	$user = $row['user'];
	$date = $row['date'];
	
	($answer && $user)
    or error("row $id is no good");
	
	$message .= "{".
		"\"answer\":\"$answer\",".
		"\"user\":\"$user\"".
	"}";
	++$id;
}
$message .= '] }';

echo $message;

?>
