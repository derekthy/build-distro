<?php
	require_once 'connect.php';
	session_start();
	require 'session.php';
?>




<!DOCTYPE html>
<html>
<head>
    <title>Tabbed Content</title>
    <script src="./tabcontent.js" type="text/javascript"></script>
    <link href="./tabcontent.css" rel="stylesheet" type="text/css" />
</head>
<body style="background:#F6F9FC; font-family:Arial;">
    <div style="margin: 0 auto; padding: 120px 80px;">
        <ul class="tabs" data-persist="true">
            <li><a href="#view1">Android</a></li>
            
            <li><a href="#sg_develop-Amazon-Development">sg_dev-Amazon-Development</a></li>
            <li><a href="#sg_develop-Amazon-Production">sg_dev-Amazon-Production</a></li>
            <li><a href="#sg_develop-Amazon-ProductionStaging">sg_dev-Amazon-ProductionStaging</a></li>
            <li><a href="#sg_develop-Amazon-Staging">sg_develop-Amazon-Staging</a></li>
            <li><a href="#sg_develop-Google-Development">sg_develop-Google-Development</a></li>
            <li><a href="#sg_develop-Google-Production">sg_develop-Google-Production</a></li>
            <li><a href="#sg_develop-Google-ProductionStaging">sg_develop-Google-ProductionStaging</a></li>
            <li><a href="#sg_develop-Google-Staging">sg_develop-Google-Staging</a></li>
            <li><a href="#sg_develop-Intel-Development">sg_develop-Intel-Development</a></li>
            <li><a href="#sg_develop-PlayPhone-Production">sg_develop-PlayPhone-Production</a></li>
            <li><a href="#sg_release-Amazon-Production">sg_release-Amazon-Production</a></li>
            <li><a href="#sg_release-Google-Production">sg_release-Google-Production</a></li>
            <li><a href="#sg_release-PlayPhone-Production">sg_release-PlayPhone-Production</a></li>
            
            <li><a href="#view2">iOs</a></li>
        </ul>
        <div class="tabcontents">
        
            <div id="view1">
				<?php
					echo "<br>";
						echo "<font size=\"30\">";
							echo "Android";
						echo "</font>";
					echo "<br>";
					require_once 'listfile_apk.php';
				?>
            </div>
            
            <div id="view2">
				<?php	
					echo "<br>";
						echo "<font size=\"30\">";
							echo "iOS";
						echo "</font>";
					echo "<br>";
					require_once 'listfile_ipa.php';
				?>
            </div>
            
        </div>
    </div>
</body>
</html>