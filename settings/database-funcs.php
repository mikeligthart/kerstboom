<?php

require_once('database-info.php');

GLOBAL $errors;
GLOBAL $successes;

$errors = array();
$successes = array();

/* Create a new mysqli object with database connection parameters */
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli;

if(mysqli_connect_errno()) {
	echo "Connection Failed: " . mysqli_connect_errno();
	exit();
}

/* ## Database functions ## */

//Fetches all the content that can be shown at the website
function getProcessedContent()
{
	GLOBAL $mysqli;
	$rows = array();

	if ($result = $mysqli->query("SELECT * FROM queue WHERE status=1 ORDER BY `id` DESC"))
	{
		while($row = $result->fetch_assoc())
		{
			$rows[] = $row;
		}
	} 
$result->close();
return $rows;
}

//Responce that is active now
function getActiveResponce()
{
		GLOBAL $mysqli;
		if ($stmt = $mysqli->prepare("SELECT `id`, `from`, `to`, `content` FROM queue WHERE status=2")) {
		
		    /* execute query */
		    $stmt->execute();
		
		    /* bind result variables */
		    $stmt->bind_result($id, $from, $to, $content);
		    $stmt->fetch();
		
		    /* close statement */
		    $stmt->close();
			
			if(empty($id)){
				return "";
			}
			else{
				$result = array("from" => $from, "to" => $to, "content" => $content);
				return $result;
			}
		}
}

function isActive(){
	$active = getActiveResponce();
	if (!empty($active)){
		return true;
	}
	else{
		return false;
	}
}

//Gets all the items from the database that still have to be processed
function getQueue(){
	GLOBAL $mysqli;
	$rows = array();

	if ($result = $mysqli->query("SELECT `timer` FROM queue WHERE status=0"))
	{
		while($row = $result->fetch_assoc())
		{
			$rows[] = $row["timer"];
		}
	} 
$result->close();
return $rows;
}

//Get first inline
function getFirstInLine(){
GLOBAL $mysqli;
		if ($stmt = $mysqli->prepare("SELECT `id`, `timer` FROM queue WHERE status=0 ORDER BY `id` ASC LIMIT 1")) {
		
		    /* execute query */
		    $stmt->execute();
		
		    /* bind result variables */
		    $stmt->bind_result($id, $timer);
		    $stmt->fetch();
		
		    /* close statement */
		    $stmt->close();
		}
		
		if (empty($id) && empty($timer)){
			return "";
		}
		else{
			return array("id" => $id, "timer" => $timer);
		}
}

//update status
function updateStatus($id, $status){
	GLOBAL $mysqli;
	$stmt = $mysqli->prepare("UPDATE queue SET `status` = ? WHERE `id` = ?");
	$stmt->bind_param('ii', $status, $id);
	$stmt->execute(); 
	$stmt->close();
}

//insert new entry
function insertNewEntry($timer_time, $from, $to, $content){
		GLOBAL $mysqli;	
		$stmt = $mysqli->prepare("INSERT INTO `queue` (`timestamp`, `timer`, `from`, `to`, `content`) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param("iisss", time(), $timer_time ,$from, $to, $content);
		$stmt->execute();
		$stmt->close();
}
?>
