<?php

$util_dir = "./hidden/";

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

// database abstraction class
class sqldb
{
	protected $db;

	function __construct()
	{
		$db = new SQLite3($util_dir."database.sqlite");
		
		$db->querySingle("SELECT value FROM global WHERE key='version'")
			or create();
	}
	
	function __destruct()
	{
		$db->close();
	}
	
	protected function create()
	{
		$create_script = file_get_contents($util_dir."create.sql")
			or error("Unable to read db create script");
	
		$db->exec($create_script)
			or error("Unable to create sqlite database: ".$db->lastErrorMsg);
	}
	
	function query($query_string)
	{
		return $db->query($query_string);
	}
  
  function querySingle($queryString)
  {
    return $db->querySingle();
  }
	
	function changes()
	{
		return $db->changes();
	}
  
  function error()
  {
    return $db->lastErrorMsg();
  }
  
  function insert_id()
  {
    return $db->lastInsertRowID();
  }
  
  function escape_string($value)
  {
    return $db->escapeString($value);
	}
  
}

function getUserId($sql, $username)
{
	isset($sql, $username)
    or error("getUserId not called with sql and username");
  
	$result = $sql->querySingle("SELECT users.id AS user_id FROM users WHERE users.name='".$username."'");
	
  if($result)
  {
    $userid = $result;
  }
  elseif(isset($result))
	{
		$sql->query("INSERT INTO users (name) VALUES ('$username')")
			or error("cant insert new user:".$sql->error);
		$userid = $sql->insert_id;
	}
	else error("Unable to query for user ids:".$sql->error);
	
	return $userid;
} // end getUserId


?>