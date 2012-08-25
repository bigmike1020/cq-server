<?php

include_once "error.php";

function getUserId($sql, $username)
{
	(isset($sql, $username)) or error("getUserId not called with sql and username");
	$result = $sql->query("SELECT id FROM users WHERE name=".$username) or error("cant find userid");
	$userid = 0;
	if($result->num_rows == 0)
	{
		$result = $sql->query("INSERT INTO users (name) VALUES ($username)")
			or error("cant insert new user");
		$userid = $sql->insert_id;
	}
	else
	{
		$row = $result->fetch_row();
		$userid = $row['id'];
	}
	
	return $userid;
}

?>