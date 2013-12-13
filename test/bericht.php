<?php
header('Content-type: test/plain');
header('Content-Disposition: attachment; filename="bericht.txt"');

$Nu = date("d-m-Y H:i:s", time());
echo "document.write( \"Nu: $Nu\")";
?>
