<?php
/**
 * 
 */
class Database_connection 
{
	
	function connect()
	{
		// code...
		$conn= new PDO("mysql:host=localhost; dbname=infosphere", "root","");
		return $conn;
	}
}
?>