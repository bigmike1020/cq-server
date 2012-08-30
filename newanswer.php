<?php

include_once "util.php";

$_POST or error("No _POST");

$pic_id = $_POST["pic_id"] 
  or error("need a pic_id");
$answer = $_POST["answer"] 
  or error("need an answer");
$answer = trim($answer);
$user =$_POST["user"]
  or "Anon";
$user = trim($user);

is_numeric($pic_id) 
  or error("pic_id is not numeric");
$pic_id = intval($pic_id);
$pic_id 
  or error("pic_id is not an integer");

$sql = new sqldb() 
  or error("Unable to init sql");

$userid = getUserId($sql, $user)
	or error("cant get userid");

$sql->query("INSERT INTO tAnswers (cUser_id, cAnswer, cPicture_id) VALUES (".
	"$userid,".
	"'".$sql->escape_string($answer)."',".
	$sql->escape_string($pic_id).
	")") 
	or error("unable to insert into answers: ".$sql->error);

$message = "{".
	"\"result\":".$sql->insert_id().
	"}";
echo $message;

?>
