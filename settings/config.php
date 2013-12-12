<?php

require_once("database-funcs.php");
require_once("funcs.php");

if(isset($_GET["lang"]) && $_GET["lang"] == "EN")
{
	require_once("settings/lang-EN.php");
}
else
{
	require_once("settings/lang-NL.php");
}

//Global variables
$TIMER_TIME = 30;

?>
