<?php
// Get incoming parameters
$movieid = isset($_GET['movieid']) ? $_GET['movieid'] : null;
$imgs = new Cselectimage();

if($imgs->validMovieId($urbax,$movieid))
{
  //get base directory
  $path = isset($_GET['path']) ? $_GET['path'] : null;
  $pathComplete = GALLERY_PATH . DIRECTORY_SEPARATOR . $path;

  //create paths
  $pathToGallery = realpath($pathComplete);
  $basePath      = realpath(GALLERY_PATH);

  //get gallery
  echo $imgs->createAndReturnGallery($basePath, $pathToGallery);
}
else 
{
   echo "Parametern movieid saknas!";
}
?>

