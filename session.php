<?php
	if (!isset($_SESSION['username'])) {
?>
	You must be logged in to view this page.<br />
	Click <a href="login.php">here</a> to go back to login page.
<?php
		die();
	}
		
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 36000)) {
	    session_unset();     // unset $_SESSION variable for the run-time 
    	session_destroy();   // destroy session data in storage
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

	if (!isset($_SESSION['CREATED'])) {
    	$_SESSION['CREATED'] = time();
	} else if (time() - $_SESSION['CREATED'] > 36000) {
	    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    	$_SESSION['CREATED'] = time();  // update creation time
	}
?>