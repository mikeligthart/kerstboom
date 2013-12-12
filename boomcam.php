<html>

<head>
<title>Boomcam</title>
</head>

<body>
<script language="JavaScript" type="text/javascript">

function reload()
{
   setTimeout('reloadImg("refresh")',1000)
};

function reloadImg(id) 
{ 
   var obj = document.getElementById(id); 
   var date = new Date(); 
   obj.src = "http://131.174.39.173:88/cgi-bin/CGIProxy.fcgi?cmd=snapPicture2&usr=visitor&pwd=&t=" + Math.floor(date.getTime()/1000); 
} 

</script>

<img src="http://131.174.39.173:88/cgi-bin/CGIProxy.fcgi?cmd=snapPicture2&usr=visitor&pwd=&t=" name="refresh" id="refresh" onload='reload(this)' onerror='reload(this)' height='400px' width='600px'> 

</body>

</html>