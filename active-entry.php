<?php

require_once("settings/config.php");
echo "
<html>
	<head>
	<title>Active Entry</title>
	<link rel='stylesheet' type='text/css' href='http://www2.ru.nl/iprox/css/2008/default.css' />
	<link rel='stylesheet' type='text/css' href='http://www2.ru.nl/iprox/css/2008/run.css' />
	<meta http-equiv='refresh' content='1' >
	</head>
	
	<body>";
	$active = getActiveResponce();
	if (empty($active)){
		echo "<b>".lang('RESPONCE_TREE_OFF')."</b>";
	}
	else{
		echo "<b>".lang('RESPONCE_TREE_NOW')." ";
		
		if (empty($active['from']))
		{
			echo lang('RESPONCE_ANONYMOUS');
		}
		else {
			echo $active['from'];
		}
		
		if (!empty($active['to']))
		{
			echo " ".lang('RESPONCE_FOR')." ".$active['to'];
		}
		
		if (!empty($active['content'])){
			echo " ".lang('RESPONCE_MESSAGE').": &quot;".$active['content']."&quot;.";
		}
		echo "</b>";
	}
echo "</body></html>";
?>