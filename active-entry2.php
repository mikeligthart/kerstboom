<?php

require_once("settings/config.php");
	$active = getActiveResponce();
	if (empty($active)){
		echo lang('RESPONCE_TREE_OFF');
	}
	else{
		echo lang('RESPONCE_TREE_NOW')." ";
		
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
	}
?>