<?php
//Loading necessary files & functions
require_once("settings/config.php");

session_start(); //Starting a session to prevent people from activating the tree several times in a minute

//Insert new message in database
if(isset($_POST["submit"]))
{
	$from = inputFilter($_POST["from"]);
	$to = inputFilter($_POST["to"]);
	$content = inputFilter($_POST["content"]);
	
	if(inputNameChecker($from) && inputNameChecker($to) && inputMessageChecker($content) && !(isset($_SESSION['last_submit']) && time()-$_SESSION['last_submit'] < 60)){
		insertNewEntry($TIMER_TIME,$from,$to,$content);
		$_SESSION['last_submit'] = time();
	}
}

//Start of HTML of page
echo"
<html>
	<head><title>".lang('INDEX_TITLE')."</title>
	<link rel='stylesheet' type='text/css' href='http://www2.ru.nl/iprox/css/2008/default.css' />
	<link rel='stylesheet' type='text/css' href='http://www2.ru.nl/iprox/css/2008/run.css' />
	<link rel='stylesheet' type='text/css' href='local.css'/>
	<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js'></script>
	<script>
		function show_data(){
			$('.responceActive').load('".$ACTIVE_ENTRY_URL."');
		}
		setInterval('show_data()', 1000);
	</script>
	</head>
	<body>
	<h1>".lang('MAIN_RADBOUD_WISH')."</h1>
	<br />

	<h2>".lang('MAIN_CHRISTMAS_ATMOSPHERE')."</h2>

	".lang('MAIN_LEAVE_MESSAGE');

	
	//Tree cam: display active responce
	echo "<br />
	<h2>".lang('MAIN_TREE_CAM')."</h2>
		<div class='responceActive'></div>";
	
	//Tree cam: load tree cam in iframe
	echo"
	<iframe src='boomcam_via_www2.php' height='420px' width='620px' frameborder='0' scrolling = '0'></iframe>
	<br />
	<br />";

	//Input form
	echo "
	<h3>".lang('MAIN_LEAVE_MESSAGE_HERE')."</h3>
	<br />	
<form name='message' action='".$_SERVER["REQUEST_URI"]."' method='post'>
	<p>
		<label>".lang('MESSAGE_INPUT_FROM')."</label>
		<br />
		<input type='text' name='from' /> ".lang('MESSAGE_OPTIONAL_NAME')."
	</p>
	<p>
		<label>".lang('MESSAGE_INPUT_TO')."</label>
		<br />
		<input type='text' name='to' /> ".lang('MESSAGE_OPTIONAL_NAME')."
	</p>
	<p>
		<label>".lang('MESSAGE_INPUT_MESSAGE')."</label>
		<br />
		<textarea rows='2' cols='50' name='content'></textarea> ".lang('MESSAGE_OPTIONAL_MESSAGE')."
	</p>";
	if (count(getQueue()) == 1)
	{
	 echo lang('NOTIFICATION_AT_THE_MOMENT_ONE')." ".count(getQueue())." ".lang('NOTIFICATION_WAITING_ONE');
	}
	elseif (count(getQueue()) > 1){
	 echo lang('NOTIFICATION_AT_THE_MOMENT')." ".count(getQueue())." ".lang('NOTIFICATION_WAITING');
	}
	echo "
	<p>
		<label>&nbsp;</label>
		<input type='submit' value='".lang('MESSAGE_SUBMIT_VALUE')."' name='submit' />
	</p>
</form>";

//Form: show notication of sent message
if(isset($_POST["submit"])){
	echo "<br /><div id='notificationOfSendMessage'>";
	
	if(inputNameChecker($from) && inputNameChecker($to) && inputMessageChecker($content)){
		echo lang('NOTIFICATION_THANK_YOU');	
		$queue = getQueue();
		if (count($queue) > 1){
			echo " ".lang("NOTIFICATION_AT_THE_MOMENT")." ".count($queue)." ".lang("NOTIFICATION_WAITING");
			echo " ".lang("NOTIFICATION_EXPECTED_WAITING_TIME");
			$waitingTime = waitingTime($queue);
			if ($waitingTime["minutes"] != 0){
				echo " ".$waitingTime["minutes"]." ".lang("NOTIFICATION_MINUTES");
				if ($waitingTime["seconds"] != 0){
					echo " ".lang("NOTIFICATION_AND");
				}
			if ($waitingTime["seconds"] != 0){
				echo " ".$waitingTime["seconds"]." ".lang("NOTIFICATION_SECONDS").".";
			}
			}	
		}		
	}

	else{
		echo lang("NOTIFICATION_TOO_LONG");
	}
	echo "</div>";
}

//Display responce history
echo "<br/></br><div id='responceField'>";
$rows = getProcessedContent();
echo "<div id='responceHistory'><h2>".lang('MAIN_MESSAGE_HISTORY')."(".count($rows).")</h2>";

//Create filters
if (isset($_GET['hisShowAnon']) && $_GET['hisShowAnon'] == "on"){
	if (!(isset($_GET['hisSize']) && $_GET['hisSize'] = "big")){
		$rows = shortWithanon($rows, 15);
		$link1 = "index.php";
		$link2 = "index.php?hisShowAnon=on&hisSize=big";
		
		if($LANGUAGE == "EN")
		{
			$link1 = $link1."?lang=EN";
			$link2 = $link2."&lang=EN";
		}
		echo "<a href='".$link1."'>".lang('RESPONCE_SHOW_ANON')." ".lang("RESPONCE_ONN")."</a>";
		echo "	|	<a href='".$link2."'>".lang('RESPONCE_SHOW_BIG')."</a>";
	}
	else{
		$link1 = "index.php?hisSize=big";
		$link2 = "index.php?hisShowAnon=on";
		
		if($LANGUAGE == "EN")
		{
			$link1 = $link1."&lang=EN";
			$link2 = $link2."&lang=EN";
		}
		echo "<a href='".$link1."'>".lang('RESPONCE_SHOW_ANON')." ".lang("RESPONCE_ONN")."</a>";
		echo "	|	<a href='".$link2."'>".lang('RESPONCE_SHOW_SMALL')."</a>";
	}
}
else{
	if (!(isset($_GET['hisSize']) && $_GET['hisSize'] = "big")){
		$rows = shortWithoutAnon($rows, 15);
		
		$link1 = "index.php?hisShowAnon=on";
		$link2 = "index.php?hisSize=big";
		
		if($LANGUAGE == "EN")
		{
			$link1 = $link1."&lang=EN";
			$link2 = $link2."&lang=EN";
		}
		echo "<a href='".$link1."'>".lang('RESPONCE_SHOW_ANON')." ".lang("RESPONCE_OFF")."</a>";
		echo "	|	<a href='".$link2."'>".lang('RESPONCE_SHOW_BIG')."</a>";
	}
	else{
		$rows = longWithoutAnon($rows);
		$link1 = "index.php?hisShowAnon=on&hisSize=big";
		$link2 = "index.php";
		
		if($LANGUAGE == "EN")
		{
			$link1 = $link1."&lang=EN";
			$link2 = $link2."?lang=EN";
		}
		
		echo "<a href='".$link1."'>".lang('RESPONCE_SHOW_ANON')." ".lang("RESPONCE_OFF")."</a>";
		echo "	|	<a href='".$link2."'>".lang('RESPONCE_SHOW_SMALL')."</a>";
	}
}

echo "<br /><br />";

//List filtered reactions
foreach ($rows as $row)
{
		echo "<div id='responceEntry'>";
		echo lang('RESPONCE_ON')." ".date('d/M ', $row["timestamp"])." ".lang('RESPONCE_AT')." ".date('G:i', $row['timestamp'])." ".lang('RESPONCE_CHRISTMAS_TREE');
		$placer = $row['from'];
		if(empty($row['from']))
		{
			$placer = lang('RESPONCE_ANONYMOUS'); 
		}
		
		echo " ".$placer;
		if (!empty($row['to']))
		{
			echo " ".lang('RESPONCE_FOR')." ".$row['to'];
		}
		if (!empty($row['content']))
		{
			echo " ".lang('RESPONCE_MESSAGE').": &quot;".$row['content']."&quot;.";
		}
		echo "</div>";
}

//End of HTML
echo"
</div>
</div>
</body>
</html>";
?>