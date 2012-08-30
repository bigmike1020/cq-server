<?php

$util_dir = "hidden/";

// The following function is an error handler which is used 
// to output an json error message and exit immediately
function error($error) 
{ 
  echo '{'.
    "\"error\": \"$error\"".
    '}';
  
  error_log("CQError: $error");
	
	if(isset($dir, $filename))
	{
    unlink($dir.$filename);
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
		$this->db = new SQLite3($util_dir."database.sqlite");
		
		$this->db->query("SELECT cValue FROM tGlobal WHERE cKey='version'")
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
			or error("Unable to create sqlite database: ".$this->error());
	}
	
	function query($query_string)
	{
		return $this->db->query($query_string);
	}
  
  function querySingle($queryString)
  {
    return $this->db->querySingle($queryString);
  }
  
  function exec($queryString)
  {
    return $this->db->exec($queryString);
  }
  
  function error()
  {
    return $this->db->lastErrorMsg();
  }
  
  function insert_id()
  {
    return $this->db->lastInsertRowId();
  }
  
  function escape_string($value)
  {
    return sqlite_escape_string($value);
	}
  
}

function getUserId($sql, $username)
{
	isset($sql, $username)
    or error("getUserId not called with sql and username");
    
  $username = trim($username);
  
	$result = $sql->querySingle("SELECT tUsers.cId AS user_id FROM tUsers WHERE tUsers.cName='".$username."'");
	
  if($result)
  {
    $userid = $result;
  }
  elseif(!isset($result))
	{
		$sql->query("INSERT INTO tUsers (cName) VALUES ('$username')")
			or error("cant insert new user:".$sql->error());
		$userid = $sql->insert_id();
	}
	else error("Unable to query for user ids:".$sql->error());
	
	return $userid;
} // end getUserId


?>
