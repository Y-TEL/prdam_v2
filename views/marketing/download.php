<?php

$file_name = $_GET['file'];
	
$mime = 'application/force-download';
header('Content-Type: '.$mime);
header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
readfile($file_name);

?>