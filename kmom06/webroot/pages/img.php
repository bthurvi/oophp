<?php 

//include class-file
require_once '../../src/image/CImage.php';


// Get incoming arguments
$src      = isset($_GET['src'])     ? $_GET['src']      : null;
$verbose  = isset($_GET['verbose']) ? true              : null;
$quality  = isset($_GET['quality']) ? $_GET['quality']  : 60;
$ignoreCache = isset($_GET['no-cache']) ? true : false;
//$saveAs   = isset($_GET['save-as']) ? $_GET['save-as']  : null; - not needed acording to MOS...
$newWidth   = isset($_GET['width'])   ? $_GET['width']    : null;
$newHeight  = isset($_GET['height'])  ? $_GET['height']   : null; 


//require src attribute
isset($src) or die('Must set src-attribute.');


//create instance of class and ouptu image
$imgFolder = dirname(__DIR__).DIRECTORY_SEPARATOR .'img'. DIRECTORY_SEPARATOR;
$cacheFolder = dirname(__DIR__).DIRECTORY_SEPARATOR .'cache'. DIRECTORY_SEPARATOR;
$cimg = new CImage($imgFolder, $cacheFolder , $src, __FILE__,$quality,$newWidth,$newHeight);
$cimg->outputImage($ignoreCache,$verbose);







