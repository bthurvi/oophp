<?php
// Get incoming parameters
$path = isset($_GET['path']) ? $_GET['path'] : null;
$pathComplete = GALLERY_PATH . DIRECTORY_SEPARATOR . $path;

//create paths
$pathToGallery = realpath($pathComplete);
$basePath      = realpath(GALLERY_PATH);

//instantiate and generate gallery
$imgGal = new CGallery();
echo $imgGal->createAndReturnGallery($basePath, $pathToGallery)
?>

