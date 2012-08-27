<?php

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

// database abstraction class
class sqldb
{
	protected $db;

	function __construct()
	{
    global $util_dir;
		$this->db = new SQLiteDatabase($util_dir."database.sqlite");
		
		$this->db->query("SELECT value FROM global WHERE key='version'")
			or $this->create();
	}
	
	function __destruct()
	{
		$this->db = NULL;
	}
	
	protected function create()
	{
    global $util_dir;
		$create_script = file_get_contents($util_dir."create.sql")
			or error("Unable to read db create script");
	
		$this->db->exec($create_script)
			or error("Unable to create sqlite database: ".$this->db->lastErrorMsg);
	}
	
	function query($query_string)
	{
		return $this->db->query($query_string);
	}
  
  function querySingle($queryString)
  {
    $result = $this->db->query($queryString)
      or error("Unable to querySingle:".$this->error());
    
    return $result->fetchSingle();
  }
  
  function error()
  {
    return $this->db->errorString();
  }
  
  function insert_id()
  {
    return $this->db->lastInsertRowId();
  }
  
  function escape_string($value)
  {
    return $this->db->escape($value);
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