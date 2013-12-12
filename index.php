<?php
require_once("settings/config.php");

//Set language
if(isset($_GET["lang"]) && $_GET["lang"] == "EN")
{
	require_once("settings/lang-EN.php");
	setlocale(LC_ALL, 'en_EN.UTF-8');
}
else
{
	require_once("settings/lang-NL.php");
	setlocale(LC_ALL, 'nl_NL.UTF-8');
}

//Insert new message in database
if(isset($_POST["submit"]))
{
	$from = $_POST["from"];
	$to = $_POST["to"];
	$content = $_POST["content"];
	
	$stmt = $mysqli->prepare("INSERT INTO `queue` (`timestamp`, `timer`, `from`, `to`, `content`) VALUES (?, ?, ?, ?, ?)");
	$stmt->bind_param("iisss", time(), $TIMER_TIME ,$from, $to, $content);
	$stmt->execute();
	$stmt->close();
}

//HTML of page
echo"
<html>
	<head><title>".lang('INDEX_TITLE')."</title>
	<link rel='stylesheet' type='text/css' href='http://www2.ru.nl/iprox/css/2008/default.css' />
	<link rel='stylesheet' type='text/css' href='http://www2.ru.nl/iprox/css/2008/run.css' />
	<style>
		#responceEntry
		{
		margin-bottom:10px;
		}
		
		#responceHistory
		{
		background-color:#F0F0F0;
		}
		
		#notificationOfSendMessage
		{
		color:#680000;
		}
		
		#inputButton
		{
		padding-left: 100px;
		}
		
	</style>
	</head>
	<body>
	<h1>".lang('MAIN_RADBOUD_WISH')."</h1>
	<br />

	<h2>".lang('MAIN_CHRISTMAS_ATMOSPHERE')."</h2>

	<h3>".lang('MAIN_LEAVE_MESSAGE')."</h3>

	
	<br />
	<h2>".lang('MAIN_TREE_CAM')."</h2>
	
	<div id='responceActive'>";
	$active = getActiveResponce();
	if (empty($active)){
		echo "<p><b>".lang('RESPONCE_TREE_OFF')."</b></p>";
	}
	else{
		echo "<p><b>".lang('RESPONCE_TREE_NOW')." ";
		
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
		echo "</b></p>";
}
echo "</div>

	<iframe src='boomcam.php' height='420px' width='620px' frameborder='0' scrolling = '0'></iframe>
	<br />
	<br />

<h3>Laat hier je boodschap achter of zet gelijk de boom aan:</h3>
<br />	
<form name='message' action='index.php' method='post'>
<p>
<label>".lang('MESSAGE_INPUT_FROM')."</label>
<br />
<input type='text' name='from' /> (optioneel)
</p>
<p>
<label>".lang('MESSAGE_INPUT_TO')."</label>
<br />
<input type='text' name='to' /> (optioneel)
</p>
<p>
<label>".lang('MESSAGE_INPUT_MESSAGE')."</label>
<br />
<textarea rows='2' cols='50' name='content'></textarea> (optioneel)
</p>";
if (count(getQueue()) == 1)
{
 echo "Op dit momenten staat er ".count(getQueue())." bericht in de wachtrij.";
}
elseif (count(getQueue()) > 1){
 echo "Op dit momenten staan er ".count(getQueue())." berichten in de wachtrij.";
}
echo "
<p>
<label>&nbsp;</label>";

//if(ae_detect_ie())
//{
	echo "<input type='submit' value='".lang('MESSAGE_SUBMIT_VALUE')."' name='submit' />";
//}
//else
//{
	//echo "<div id='inputButton'><input type='image' src='images/boombanner.jpg' height='200px' width='400px' onclick='this.form.submit();' value='".lang('MESSAGE_SUBMIT_VALUE')."' name='submit' /></div>";
//}

echo"
</p>
</form>";

//Show notication of sent message
if(isset($_POST["submit"])){
	echo "<br /><div id='notificationOfSendMessage'>".lang('NOTIFICATION_THANK_YOU');
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
	echo "</div>";
}

// DISPLAY RESPONCES
echo "<br/></br><div id='responceField'>";

//Display active responce


//Display responce history
$rows = getProcessedContent();
echo "<div id='responceHistory'><h2>Berichtengeschiedenis (".count($rows).")</h2>";
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


echo"
</div>
</div>
</body>
</html>";


?>
