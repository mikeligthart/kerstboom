<?php
include_once("connect-database.php");


$MATCHING_IP = "131.174.39.172";

if (!($_SERVER['REMOTE_ADDR'] == $MATCHING_IP) && !($_SERVER['REMOTE_ADDR'] == "131.174.217.73")){die("Authentication fail");}
if(!isset($_GET["i"]) || !isset($_GET["s"])){die("Not the right format");}

$id = $_GET["i"];
$status = $_GET["s"];

updateStatus($id, $status);


?>