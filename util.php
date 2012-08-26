<?php
namespace util;

$util_dir = "hidden/";

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
	
	function changes()
	{
		return $db->changes();
	}
  
  function last_error()
  {
    return $db->lastErrorMsg();
  }
  
  function escapeString($value)
  {
    return $db->escapeString($value);
	}
  
}

?>