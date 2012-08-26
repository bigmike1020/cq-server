<?php

// The following function is an error handler which is used 
// to output an json error message and exit immediately
function error($error, $seconds = 5) 
{ 
    echo '{'.
	"\"error\": \"$error\"".
	'}';
	
	if(isset($uploadFilename, $uploadsDirectory))
	{
		unlink($uploadsDirectory.$uploadFilename);
	}
    exit; 
} // end error handler 

function getUserId($sql, $username)
{
	(isset($sql, $username)) or error("getUserId not called with sql and username");
	$result = $sql->query("SELECT users.id AS user_id FROM users WHERE users.name='".$username."'") 
		or error("cant query for userid: ".$sql->error);
	$userid = 0;
	if($result->num_rows == 0)
	{
		$result = $sql->query("INSERT INTO users (name) VALUES ('$username')")
			or error("cant insert new user:".$sql->error);
		$userid = $sql->insert_id;
	}
	else
	{
		$row = $result->fetch_array();
		$userid = $row['user_id'];
	}
	
	return $userid;
} // end getUserId

?>