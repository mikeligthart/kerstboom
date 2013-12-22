<?php
//Loading necessary files & functions
require_once("settings/config.php");

//Start of HTML of page
echo"
<html>
	<head><title>".lang('INDEX_TITLE')."</title>
	<link rel='stylesheet' type='text/css' href='http://www2.ru.nl/iprox/css/2008/default.css' />
	<link rel='stylesheet' type='text/css' href='http://www2.ru.nl/iprox/css/2008/run.css' />
	<link rel='stylesheet' type='text/css' href='local.css'/>
	</head>
	<body>
	<h1>".lang('MAIN_RADBOUD_WISH')."</h1>
	<br />

	<h2>".lang('MAIN_TREE_ON_HOLLIDAY')."</h2>

	".lang('MAIN_VIEW_MESSAGE');

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