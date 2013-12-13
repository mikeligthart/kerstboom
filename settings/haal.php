<?php
include_once("database-funcs.php");

$data = getFirstInLine();
$file = fopen("data.txt", 'w') or die("can't open file");

if (empty($data)){
	fwrite($file, "");
}
else{
	$stringData = $data["id"].";".$data["timer"]." ";
	fwrite($file, $stringData);
}

header("Content-disposition: attachment; filename=data.txt");
header("Content-type: text/plain:");
readfile('data.txt');
?>
