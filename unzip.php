<?php  
	// $zip = new ZipArchive();
	// $zip->open('sys/font_files.zip', ZipArchive::CREATE);
	// $zip->addFile('sys/');
	// $zip->close();
	// Include and initialize Extractor class
require_once 'compress.php';
$extractor = new Extractor;
$archivePath = 'sys.zip';
$destPath = '/sys/test/';
$extract = $extractor->extract($archivePath, $destPath);
if($extract){
    echo $GLOBALS['status']['success'];
}else{
    echo $GLOBALS['status']['error'];
}
?>