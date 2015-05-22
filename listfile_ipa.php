<html>
	<body>
<?php
	require_once 'connect.php';
	session_start();
	require 'session.php';
	
    // List files with directory qadeploy as root    
    $root_dir	= "./../qadeploy_ipa/";
        
    if ( !is_dir($root_dir) ) {
        exit('Invalid diretory path');
    }
	    
    function create_plist($base_plist, $root_dir, $target_file_name, $dest_dir) {
    	//Create plist file		
		//Open the base_ipa.plist and write into a new file while modifying CHANGE_THIS_NAME

		$myfile		= fopen($base_plist, "r") or die("Unable to open file!");
		$newfile 	= fopen($root_dir . $dest_dir . "/" . $target_file_name . ".plist", "x") or die("Unable to create file!");
				
		// Output one line until end-of-file
		while(!feof($myfile)) {
			$cur_txt = fgets($myfile);
			//echo $cur_txt . "<br>";
			
			if ( strpos( $cur_txt, "CHANGE_THIS_NAME" ) ) {
				$loc = "http://" . $_SERVER['SERVER_NAME'] . "/qadeploy_ipa/" . $dest_dir . "/" . $target_file_name . ".ipa";
				$cur_txt = str_replace ("CHANGE_THIS_NAME", $loc, $cur_txt);				
			}
			
			fwrite($newfile, $cur_txt);
		}
		fclose($myfile);
		fclose($newfile);

    }
        
    function check_plist($directory, $target, $dest_dir) {
    
    	$base_plist	= "./../qadeploy_ipa/base_ipa.plist";
    	$root_dir	= "./../qadeploy_ipa/";
    
    	//Check if plist file is available.
    	//If plist file is available, return plist file.
    	//Else if plist is not available, create the plist file.
		
		$target_file_name = substr($target, 0, strpos( $target, ".ipa" ));
		$is_plist_found = FALSE;

		foreach ( scandir ($directory.$dest_dir) as $file ) {

			if ( strcmp($file, $target_file_name . ".plist") == 0 ) {
				//echo "no need to generate since plist for ipa file found: " . $file . "<br>";
				$is_plist_found = TRUE;
				break;
			} /*else {
				echo "Compare \"" . $target_file_name . ".plist\"" . " with \"" . $file . "\"" . "<br>";
			}*/
		}
		
		if ( $is_plist_found == FALSE ) {
			//echo "plist for ipa file not found. Generating file.<br>";
			create_plist($base_plist, $root_dir, $target_file_name, $dest_dir);
		}
   		
   		return $target_file_name . ".plist"; //return hardcoded plist file name.
    }
        
    function xmlHttpRequest($ipa_url)
    {
?>
		<script>
		
		    var onLoadHandler = function(event) 
    		{
	            var req = event.target;                                
            	var clen = req.getResponseHeader("Content-Length");

    	        if( clen == null || clen == 0 )
        	        return;
                
	            req.abort();
    
            	var size = ( ((clen / 1024)/1024) ).toFixed(2) + " MB";
            
            	if( document.getElementById(uniqueid).innerHTML.length == 0 )
                	document.getElementById(uniqueid).innerHTML = size;
	    	}

		    var req = !window.XMLHttpRequest ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;
		    req.open('HEAD', <?php echo $ipa_url ?>);

		    req.onreadystatechange = onLoadHandler;
		    req.send();

		</script>
<?php
    }
        
	foreach ( scandir($root_dir) as $dir ) {
		
		$full_path = $root_dir . $dir;
		
		$ignoreParentDir = str_replace($root_dir, '', $full_path);
		$ignoreCurrentDir = str_replace($root_dir, '', $full_path);
				
		if ( '.'	== $ignoreParentDir )	continue;
		if ( '..'	== $ignoreCurrentDir )	continue;
		if ( !is_dir($full_path) )			continue;
				
		if ( is_dir($full_path) ) {
			echo $dir;
			
			$arr	  	= array();
			$ipa_arr 	= array();
			$dsym_arr	= array();
			
			foreach ( scandir ($full_path) as $file ) {
				if ( strpos( $file, ".apk" ) || strpos( $file, ".ipa" ) ) {
					$target 	= $full_path . "/" . $file;
					$plist_name = check_plist($root_dir, $file, $dir);
										
					//file_size function is in listfile_apk.php					
					$plist_url = "http://devderek.hj.cx/qadeploy_ipa/" . $dir . "/" . $plist_name;
					$arr[]= "<a href=\"itms-services://?action=download-manifest&url=" . $plist_url . "\">". $file . " (" . file_size($target) . ")</a>";
					
					//$ipa_arr[] = $target;
					$ipa_arr[]	= " <a href=\"download.php?dest=" . urlencode($target) . "\"> " . ".ipa" . "</a> ";
					$dsym_arr[]	= " <a href=\"download.php?dest=" . urlencode( substr($target, 0, strpos( $target, ".ipa" )) . "-dSYM.zip" ) . "\"> " . ".dSYM" . "</a> ";
				}
			}
			
			for ($i = count($arr)  ; $i >= 0 ; $i-- ) {
				xmlHttpRequest($ipa_arr[i]);
				echo $arr[$i] . $ipa_arr[$i] . $dsym_arr[$i] . "<br>";
			}
			
			echo "<br />";
		}
	}
?>
	</body>
</html>