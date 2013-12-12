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

function ae_detect_ie()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}
?>
