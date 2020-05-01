<?php
class Extractor {
    public static function extract($archive, $destination){
        $ext = pathinfo($archive, PATHINFO_EXTENSION);
        switch ($ext){
            case 'zip':
                $res = self::extractZipArchive($archive, $destination);
                break;
            case 'gz':

                $res = self::extractGzipFile($archive, $destination);
                break;
            case 'rar':

                $res = self::extractRarArchive($archive, $destination);
                break;
        }
        print $archive;
        return $res;
    }
    
    public static function extractZipArchive($archive, $destination){
        if(!class_exists('ZipArchive')){
            $GLOBALS['status'] = array('error' => 'Your PHP version does not support unzip functionality.');
            return false;
        }
    
        $zip = new ZipArchive;
    
        if($zip->open($archive) === TRUE){
            if(is_writeable($destination . '/')){
                $zip->extractTo($destination);
                $zip->close();
                $GLOBALS['status'] = array('success' => 'Files unzipped successfully');
                return true;
            }else{
                $GLOBALS['status'] = array('error' => 'Directory not writeable by webserver.');
                return false;
            }
        }else{
            $GLOBALS['status'] = array('error' => 'Cannot read .zip archive.');
            return false;
        }
    }
    
    public static function extractGzipFile($archive, $destination){
        if(!function_exists('gzopen')){
            $GLOBALS['status'] = array('error' => 'Error: Your PHP has no zlib support enabled.');
            return false;
        }
    
        $filename = pathinfo($archive, PATHINFO_FILENAME);
        $gzipped = gzopen($archive, "rb");

        $file = fopen($filename, "w");
    
        while ($string = gzread($gzipped, 4096)) {
            fwrite($file, $string, strlen($string));
        }
        gzclose($gzipped);

        fclose($file);
    
        if(file_exists($destination.'/'.$filename)){
            $GLOBALS['status'] = array('success' => 'File unzipped successfully.');
            return true;
        }else{
            $GLOBALS['status'] = array('error' => 'Error unzipping file.');
            return false;
        }
    }
    
    public static function extractRarArchive($archive, $destination){
        if(!class_exists('RarArchive')){
            $GLOBALS['status'] = array('error' => 'Your PHP version does not support .rar archive functionality.');
            return false;
        }
        if($rar = RarArchive::open($archive)){

            if (is_writeable($destination . '/')) {
                $entries = $rar->getEntries();
                foreach ($entries as $entry) {
                    $entry->extract($destination);
                }
                $rar->close();
                $GLOBALS['status'] = array('success' => 'File extracted successfully.');
                return true;
            }else{
                $GLOBALS['status'] = array('error' => 'Directory not writeable by webserver.');
                return false;
            }
        }else{
            $GLOBALS['status'] = array('error' => 'Cannot read .rar archive.');
            return false;
        }
    }
    
}