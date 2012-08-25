<?php

include_once "error.php";
include_once "newuser.php";

$_POST or error("No _GET");

$pic_id = $_POST["pic_id"] or error("need a pic_id");
$answer = $_POST["answer"] or error("need an answer");
$user = $_POST["user"] or "Anonymous";

is_numeric($pic_id) or error("pic_id is not numeric");
$pic_id = intval($pic_id);
$pic_id or error("pic_id is not an integer");

$sql = mysqli_init() or error("Unable to init mysql");

$sql->real_connect(ini_get("mysql.default_host"), "root") or error("Unable to connect to mysql");
$sql->select_db('chunky') or error("Unable to select chunky db: ".$sql->error);

$userid = getUserId($sql, $user)
	or error("cant get userid");

$sql->query("INSERT INTO answers (user_id, answer, picture_id) VALUES (".
	"$userid,".
	"'".$sql->real_escape_string($answer)."',".
	$sql->real_escape_string($pic_id).
	")") 
	or error("unable to insert into answers: ".$sql->error);

$message = "{".
	$sql->insert_id.
	"}";
echo $message;

$sql->close();

?>