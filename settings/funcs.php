<?php

//Inputs language strings from selected language.
function lang($key,$markers = NULL)
{
	global $lang;
	if($markers == NULL)
	{
		$str = $lang[$key];
	}
	else
	{
		//Replace any dyamic markers
		$str = $lang[$key];
		$iteration = 1;
		foreach($markers as $marker)
		{
			$str = str_replace("%m".$iteration."%",$marker,$str);
			$iteration++;
		}
	}
	//Ensure we have something to return
	if($str == "")
	{
		return ("No language key found");
	}
	else
	{
		return $str;
	}
}

//get all the timers and return waiting time in minutes
function waitingTime($items){
	$totalWaitingTime = 0;
	foreach ($items as $item){
		$totalWaitingTime = $totalWaitingTime + $item;
	}
	
	$minutes = floor($totalWaitingTime / 60);
	$seconds = $totalWaitingTime% 60;
	
	return array("minutes" => $minutes, "seconds" => $seconds);
}

//detect if browser is IE
function ae_detect_ie()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}

//long with anon -> do nothing
//long without anon -> filter aanon
//short with anon -> slice
//short without anon -> filter anon & slice

function filterAnon($var){
	return (!empty($var['from']));
}


function longWithoutAnon($rows){
	$result = array_filter($rows,"filterAnon");
	return $result;
}

function shortWithanon($rows, $size){
	$result = array_slice($rows, 0, $size);
	return $result;
}

function shortWithoutAnon($rows, $size){
	$result = array_filter($rows,"filterAnon");
	$result = array_slice($result, 0, $size);
	return $result;
}

function inputNameChecker($name){
	if (strlen($name) > 50){
		return false;
	}
	else {
		return true;
	}	
}

function inputMessageChecker($message){
	if (strlen($message) > 140){
		return false;
	}
	else {
		return true;
	}
}

function isIPFromCampus(){
	$compareA = substr($_SERVER['REMOTE_ADDR'], 0, 7);
	$compareB = "131.174";

	if (strcmp($compareA, $compareB) == 0) {
	 return true;
	}
	else {
	 return false;
	}
}

function inputFilter($input){
$output = filter_var($input, FILTER_SANITIZE_STRING);
return $output;

}

?>
