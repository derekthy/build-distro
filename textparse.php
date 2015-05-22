<?php

	require_once 'connect.php';
	session_start();
	require 'session.php';

?>

<html>
	<body>
		<form action="upload_file.php" method="post" enctype="multipart/form-data">
			<label for="file">Filename:</label>
			<input type="file" name="file" id="file"><br>
			<input type="submit" name="submit" value="Submit">
		</form>
	</body>
</html>
