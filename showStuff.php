<?php
	require_once 'connect.php';
		
	session_start();
	if (isset($_SESSION['username'])){
		echo "Hai you've come to showStuff";
?>	
	
	<h1>This is a test title</h1>
	
<?php
	}else{
		die("sorry, you must be logged in to view this page");
}
?>