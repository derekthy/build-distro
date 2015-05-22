<?php
	require_once 'connect.php';
	session_start();
	require 'session.php';
	
    // List files with directory qadeploy as root    
    $root_dir = "./../qadeploy/";
    
    if (! is_dir($root_dir)) {
        exit('Invalid diretory path');
    }
	
	function file_size($url){ 
    	$size = filesize($url); 
	    if($size >= 1073741824){ 
    	    $fileSize = round($size/1024/1024/1024,1) . 'GB'; 
	    }elseif($size >= 1048576){ 
    	    $fileSize = round($size/1024/1024,1) . 'MB'; 
	    }elseif($size >= 1024){ 
    	    $fileSize = round($size/1024,1) . 'KB'; 
	    }else{ 
        	$fileSize = $size . ' bytes'; 
    	} 
    	return $fileSize;
    }
    
    function parse_displayName($name) {
    	    	
    	$exploded_name 		= explode("_", $name);
    	    	
    	$build_timestamp 	= "";
					
		$exploded_date = explode( "-", $exploded_name[4] );
    	$exploded_time = explode( "-", $exploded_name[5] );
    		
    	$final_date = $exploded_date[2] . "/" . $exploded_date[1] . "/" . $exploded_date[0];
    	$final_time = "";
    		
    	if ( $exploded_time[0] > 12 ) {
    		$exploded_time[0] = $exploded_time[0] - 12;
    		if (strlen($exploded_time[0]) < 2) {
    			$exploded_time[0] = "0" . $exploded_time[0];
    		}

   			$final_time = $exploded_time[0] . ":" . $exploded_time[1] . "PM"; 
   		} else {
   		    if (strlen($exploded_time[0]) < 2) {
   				$exploded_time[0] = "0" . $exploded_time[0];
   			}
   			$final_time = $exploded_time[0] . ":" . $exploded_time[1] . "AM"; 
   		}
    		
   		$build_timestamp	=	"[" . $final_date . " - " . $final_time . "]";
    		
   		$build_no = $exploded_name[6];
   		if ( strpos( $build_no, ".apk" ) ) {
   			$build_no = substr($build_no, 0, strpos( $build_no, ".apk" ));
   		}
    		
   		$build_no_length	= strlen($build_no);
   		$build_no_max_digit	= 4;
   		$build_no_prefix	= "";
		$build_no			= substr($build_no, 1, $build_no_length-1);
	
   		if ( $build_no_length < $build_no_max_digit ) {
   			for ( $i = 0 ; $i < ($build_no_max_digit - $build_no_length) ; $i++ ) {
   				$build_no_prefix = $build_no_prefix . "0";
   			}
   		}
    		
   		$build_no = "#" . $build_no_prefix . $build_no;

   		$new_name			=	$build_no		 	.
   								" "					.
    							$build_timestamp	.
   								" "					.
   								$exploded_name[1]	.
   								" "					.
   								$exploded_name[0];
				
    	if ( !is_null($exploded_name[7]) ) {
    		return $new_name . " " . $exploded_name[7] ;
    	}
    	
    	return $new_name;
    }
	
	foreach ( scandir($root_dir) as $dir ) {
		
		$full_path = $root_dir . $dir;
		
		$ignoreParentDir = str_replace($root_dir, '', $full_path);
		$ignoreCurrentDir = str_replace($root_dir, '', $full_path);
				
		if ( '.'	== $ignoreParentDir )	continue;
		if ( '..'	== $ignoreCurrentDir )	continue;
		if ( !is_dir($full_path) )			continue;
				
		if ( is_dir($full_path) ) {
			echo "<a name=\"" . $dir . "\">" . $dir . "</a>" . "<br />";
			
			$arr = array();
			
			foreach ( scandir ($full_path) as $file ) {
				if ( strpos( $file, ".apk" ) || strpos( $file, ".ipa" ) ) {
					$target = $full_path . "/" . $file;
					
					//echo "<a href=\"download.php?dest=" . urlencode($target) . "\"> " . parse_displayName($file) . " (" . file_size($target) . ")</a>";
					$arr[] = "<a href=\"download.php?dest=" . urlencode($target) . "\"> " . parse_displayName($file) . " (" . file_size($target) . ")</a>" . "<br />";
				}
			}
			
			for ($i = count($arr)  ; $i >= 0 ; $i-- ) {
				echo $arr[$i];
			}
			
			echo "<br />";
		}
	}
?>