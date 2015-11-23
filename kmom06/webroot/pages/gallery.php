<?php
// Get incoming parameters
$path = isset($_GET['path']) ? $_GET['path'] : null;
$pathComplete = GALLERY_PATH . DIRECTORY_SEPARATOR . $path;
$pathToGallery = realpath($pathComplete);

$basePath      = realpath(GALLERY_PATH);

$imgGal = new CGallery();
$imgGal->setBasePath($basePath);
$imgGal->setImageGalleryPath($pathToGallery);


echo "<h1>Bildgalleri</h1>";
echo $imgGal->createBreadcrumb($pathToGallery);
echo $imgGal->display();
?>

