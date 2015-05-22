<?php
	require_once 'connect.php';
	session_start();
	require_once 'session.php';
	
	if (!isset($_SESSION['username'])) {
		die("sorry, you must be logged in to view this page");
	}

	$received = $_GET['dest'];
		
	if (file_exists($received)) {
    	header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename='.basename($received));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
    	header('Pragma: public');
	    header('Content-Length: ' . filesize($received));
    	readfile($received);
    exit;
	} else {
		echo "value received: " . $received . "<br/>";
		echo "File does not exist!" . "<br/>";
	}

?>