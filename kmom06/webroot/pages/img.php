<?php 

require_once '../config.php';
require_once '../../src/image/CImage.php';


// Get incoming arguments
$src      = isset($_GET['src'])     ? $_GET['src']      : null;
$verbose  = isset($_GET['verbose']) ? true              : null;


//require src attribute
isset($src) or errorMessage('Must set src-attribute.');


$cimg = new CImage(URBAX_IMG_PATH, $src, __FILE__);


$cimg->outputImage($verbose);







