<html>

<head>
<title>Boomcam</title>

<script language="JavaScript" type="text/javascript">

N = 0;

function Reload_Bericht() 
{ 
	var obj = document.getElementById("Bericht"); 
	var date = new Date(); 
	alert( "http://communicatie.ruhosting.nl/kerstboom/test/bericht.php?" + Math.floor(date.getTime()/1000) ); 
	// obj.src = "http://communicatie.ruhosting.nl/kerstboom/test/bericht.php?" + Math.floor(date.getTime()/1000); 

	N++;
	if ( N <=2 ) { setTimeout('Reload_Bericht()',1000); }
} 
</script>

</head>

<body>

<div id="XX_Bericht">
<!--script id="Bericht" type="text/javascript" src="./bericht.php"></script-->
</div>

<div id="Try">Test</div>

<script language="JavaScript" type="text/javascript">
	var obj = document.getElementById("Try"); 
	obj.innerHTML = "<scri" + "pt type=\"text/javascript\" src=\"./bericht.php\"" + ">" + "<" + "/scri" + "pt>";

</script>

<!--
<script language="JavaScript" type="text/javascript">Reload_Bericht();</script>
-->

</body></html>
