<?php

include_once "util.php";
use util\error;

$_POST or error("No _GET");

$pic_id = $_POST["pic_id"] 
  or error("need a pic_id");
$answer = $_POST["answer"] 
  or error("need an answer");
$user = $_POST["user"] 
  or "Anonymous";

is_numeric($pic_id) 
  or error("pic_id is not numeric");
$pic_id = intval($pic_id);
$pic_id 
  or error("pic_id is not an integer");

$sql = new util\sqldb() 
  or error("Unable to init sql");

$userid = getUserId($sql, $user)
	or error("cant get userid");

$sql->query("INSERT INTO answers (user_id, answer, picture_id) VALUES (".
	"$userid,".
	"'".$sql->escape_string($answer)."',".
	$sql->escape_string($pic_id).
	")") 
	or error("unable to insert into answers: ".$sql->error);

$message = "{".
	"\"result\":".$sql->insert_id.
	"}";
echo $message;

?>