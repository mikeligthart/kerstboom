<?php

require_once("database-funcs.php");
require_once("funcs.php");

if(isset($_GET["lang"]) && $_GET["lang"] == "EN")
{
	$LANGUAGE = "EN";
	$ACTIVE_ENTRY_URL = "active-entry2.php?lang=EN";
	require_once("settings/lang-EN.php");
}
else
{
	$LANGUAGE = "NL";
	$ACTIVE_ENTRY_URL = "active-entry2.php";
	require_once("settings/lang-NL.php");
}

//Global variables
$TIMER_TIME = 30;

?>
