<?php
  $dir = $_POST['dir'];
  if (!mkdir($dir, true))  
    { 
       echo('Folder Failed to create'); 
    } else { 
       echo('Folder created success'); 
    }

function delete_files($target) {
	if(is_dir($target)){
	    $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

	    foreach( $files as $file ){
	        delete_files( $file );      
	    }

	    rmdir( $target );
	} elseif(is_file($target)) {
	    unlink( $target );  
	}
} 
?>