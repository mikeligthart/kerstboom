<html>

<head>
<title>Boomcam</title>
</head>

<body>

<?php
	if (	$_SERVER['REMOTE_ADDR'] == 'XXX195.169.217.46')
	{
		echo " --"; exit(2);
	}
?>

<script language="JavaScript" type="text/javascript">

var CamUrl = "http://www2.ru.nl/cgi-bin/vieringen/kb_toon2.pl?t="; 

function reload()
{
   setTimeout('reloadImg("refresh")',1000)
};

function reloadImg(id) 
{ 
   var obj = document.getElementById(id); 
   var date = new Date(); 
   obj.src = CamUrl + Math.floor(date.getTime()/1000); 
} 

</script>

<img src="http://www2.ru.nl/cgi-bin/vieringen/kb_toon2.pl?t=" name="refresh" id="refresh" onload='reload(this)' onerror='reload(this)' height='400px' width='600px'> 

</body>

</html>
