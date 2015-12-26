<?php

// Get incoming parameters
$movieid = isset($_GET['movieid']) ? $_GET['movieid'] : null;
$imgs = new Cselectimage($urbax, $movieid);
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;




if($imgs->validMovieId($movieid))
{
  // if user is NOT authenticated.
  if($acronym==null)
  {
    $out = <<<EOD
  <div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
      <h2 style="margin-top: 0;">Du måste vara inloggad för att få koppla bilder</h2>
      <p>Använd menyn uppe till höger på denna sida.</p>
  </div>
EOD;
 
    echo $out;
  }
  else
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
}
else 
{
   echo "Parametern movieid saknas eller är ogiltig!";
}
?>

