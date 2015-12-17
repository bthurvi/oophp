<?php


/**
 * Description of CGallery
 *
 * @author urbvik
 */
class Cselectimage {
 
  private $basePath=null;
  private $path = null;
  private $title;
  private $id;
  private $dbh;
  private $connectedImages = array();
  
  public function __construct($urbax, $movieid) 
  {
    $this->dbh = new CDatabase($urbax['database']);
    
    //check that movie_id exist in database
    if(!$this->validMovieId($movieid))
      die("invalid movieID");    
    
    //uppdate database
    if(isset($_POST['saveMovies2Images']))
      $this->saveMoviesToImages();
    
    //get the images that are connected to the movie
    $sql = "SELECT image FROM images WHERE id IN (SELECT image_id FROM movie2image WHERE movie_id=?)";
    $params = array($this->id);
    $res = $this->dbh->ExecuteSelectQueryAndFetchAll($sql,$params);
    
    //convert obect array to string array
    foreach ($res as $r) 
      $this->connectedImages[]=$r->image;
    
    
    
  }
  
  private function saveMoviesToImages()
  { 
    //delete old entries
    
    $sql = "DELETE FROM movie2image WHERE movie_id=?";       
    $params = array($this->id);
    $this->dbh->ExecuteSelectQueryAndFetchAll($sql,$params);
    
    
    //insert new entries
    $ids = $this->getImageIds($_POST['selectedimages']);
    
    $sql2 = "INSERT INTO movie2image(movie_id,image_id) VALUES ";
   
    $params = null;
    foreach ($ids as $id) 
    {
      $params[] = $this->id;
      $params[] = $id;
      $sql2 .= "(?,?), ";
    }
    $sql2 = rtrim($sql2, ' ');
    $sql2 = rtrim($sql2, ',');
   
    $this->dbh->ExecuteQuery($sql2, $params);
    
  
  }
  
  private function getImageIds($imgNames)
  {
    $imgpaths = array();
    foreach ($imgNames as $imgName) 
    {
      $imgpaths[]="'img/movie/$imgName'";
    }
    $imagesPathString = implode(',', $imgpaths);
    
    $sql = "SELECT id from images WHERE image IN($imagesPathString)";
    $res = $this->dbh->ExecuteSelectQueryAndFetchAll($sql);
    
    $return = array();
    foreach ($res as $r) {
      $return[] = $r->id;
    }
    
    return $return;
  }
  
  public function createAndReturnGallery($basePath,$pathToGallery)
  {
    $this->setBasePath($basePath);
    $this->setImageGalleryPath($pathToGallery); 
    
    $html_code  = "<form method='post'><h1>Bilder till: $this->title</h1>";
    $html_code .= "<p>Markera de bilder som hör samman med filmen.</p>";
            
    //$html_code .= $this->createBreadcrumb($pathToGallery);
    $html_code .= $this->display()."<input type='submit' value='Spara' name='saveMovies2Images'></form>";
    
    $html_code .= "<div>" . $this->getFileUploadForm($_SERVER['QUERY_STRING']) . "</div>";
    
    
    return $html_code;
  }
  
  private function getFileUploadForm($action)
  {
    return <<<EOD
      <form action="?$action" method="post" id="fileUploadForm" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" class="displayNone" id="fileToUpload">
        <label for="fileToUpload" class="aButton" id="fileToUploadLabel"><i class="fa fa-upload"></i> Ladda upp ny bild!</label>  
        <input type="submit" class="displayNone" value="Ladda upp!" name="submit" id="fileUpploadButton"> 
      </form>
EOD;
  }
  
   /**
   * Function for setting the base path
   * @param string $newBasePath the path to the  ROOT DIRECTORY (top level of wich files/images that can bee shown.
   */
  public function setBasePath($newBasePath)
  {
    if ($newBasePath == false || $newBasePath == null) {
      $this->errorMessage("New basepath not valid.");
    }

    if (!is_dir($newBasePath)) {
      $this->errorMessage("The new basepath is NOT a directory!");
    }

    $this->basePath = $newBasePath;
  }
  
   /**
   * Function for validating a path to basePath
   * @param string $npath the path to DIRECTORY contaning all the images for the gallery.
   */
  public function setImageGalleryPath($path)
  {
    if($this->basePath==null){
      $this->errorMessage("Base path must be set before validating path");
    }
    
    if ($path == false || $path == null) {
      $this->errorMessage("Image gallery path not valid.");
    }
    
    if (substr_compare($this->basePath, $path, 0, strlen($this->basePath)) != 0) {
      $this->errorMessage("Security constraint: Image gallery must lie below the basePath.");
    }
    
    $this->path = $path;

    return true;
  }
  
  
   /**
   * Function for displaying gallery/image in currrent path
   */
  public function display() 
  {
    // Read and present images in the current directory
    if(is_dir($this->path)) {
      $gallery = $this->readAllItemsInDir($this->path);
    }
    else if(is_file($this->path)) {
      $gallery = $this->readItem($this->path);
    }
    
    return $gallery;
  }
  
  /**
 * Read directory and return all items in a ul/li list.
 *
 * @param string $path to the current gallery directory.
 * @param array $validImages to define extensions on what are considered to be valid images.
 * @return string html with ul/li to display the gallery.
 */
private function readAllItemsInDir($path, $validImages = array('png', 'jpg', 'jpeg','gif')) {
  $files = glob($path . '/*'); 
  $gallery = "<ul class='gallery'>\n";
  $len = strlen(GALLERY_PATH);
 
  foreach($files as $file) {
    $parts = pathinfo($file);
    $href  = str_replace('\\', '/', substr($file, $len + 1));
 
    // Is this an image or a directory
    if(is_file($file) && in_array($parts['extension'], $validImages)) {
      $item    = "<img src='pages/img.php?src=" 
        . GALLERY_BASEURL 
        . $href 
        . "&amp;width=80&amp;height=80&amp;crop-to-fit' alt=''/>";
      $caption = basename($file); 
    }
    elseif(is_dir($file)) {
      $item    = "<img src='pages/img.php?src=folder/folder.png&amp;width=128&amp;height=128&amp;crop-to-fit' alt=''/>";
      $caption = basename($file) . '/';
    }
    else {
      continue;
    }
 
    // Avoid to long captions breaking layout
    $fullCaption = $caption;
    if(strlen($caption) > 18) {
      $caption = substr($caption, 0, 10) . '…' . substr($caption, -5);
    }
    
    $mark='';
    $checked = '';
    if(in_array("img/movie/".basename($file),$this->connectedImages))
    {  
      $mark = "markAsSelected";
      $checked = "checked='checked'";
    }
    
 
    $gallery .= "<li class='{$mark}'><label><input type='checkbox' $checked value='" . basename($file) ."' name='selectedimages[]' class='displayNone'><figure class='figure overview'>{$item}<figcaption>{$caption}</figcaption></figure></label></li>\n";
  }
  $gallery .= "</ul>\n";
 
  return $gallery;
}

/**
 * Read and return info on choosen item.
 *
 * @param string $path to the current gallery item.
 * @param array $validImages to define extensions on what are considered to be valid images.
 * @return string html to display the gallery item.
 */
private function readItem($path, $validImages = array('png', 'jpg', 'jpeg', 'gif')) {
  $parts = pathinfo($path);
  if(!(is_file($path) && in_array($parts['extension'], $validImages))) {
    return "<p>This is not a valid image for this gallery.";
  }
 
  // Get info on image
  $imgInfo = list($width, $height, $type, $attr) = getimagesize($path);
  $mime = $imgInfo['mime'];
  $gmdate = gmdate("D, d M Y H:i:s", filemtime($path));
  $filesize = round(filesize($path) / 1024); 
 
  // Get constraints to display original image
  $displayWidth  = $width > 800 ? "&amp;width=800" : null;
  $displayHeight = $height > 600 ? "&amp;height=600" : null;
 
  // Display details on image
  $len = strlen(GALLERY_PATH);
  $href = GALLERY_BASEURL . str_replace('\\', '/', substr($path, $len + 1));
  $item = <<<EOD
<p><img src='pages/img.php?src={$href}{$displayWidth}{$displayHeight}' alt=''/></p>
<p>Original image dimensions are {$width}x{$height} pixels. <a href='pages/img.php?src={$href}'>View original image</a>.</p>
<p>File size is {$filesize}KBytes.</p>
<p>Image has mimetype: {$mime}.</p>
<p>Image was last modified: {$gmdate} GMT.</p>
EOD;
 
  return $item;
}


  /**
   * Function for displaying error messages
   * @param string $message the error message to display.
   */
  private function errorMessage($message)
  {
    header("Status: 404 Not Found");
    die('img.php says 404 - ' . htmlentities($message));
  }
  
  
  /**
 * Create a breadcrumb of the gallery query path.
 *
 * @param string $path to the current gallery directory.
 * @return string html with ul/li to display the thumbnail.
 */
  public function createBreadcrumb($path) 
  {
    //echo "Directory separator:" .DIRECTORY_SEPARATOR;
    //$parts = explode('/', trim(substr($path, strlen(GALLERY_PATH) + 1), '/'));
    //$parts = explode('DIRECTORY_SEPARATOR', trim(substr($path, strlen(GALLERY_PATH) + 1), 'DIRECTORY_SEPARATOR'));
    
    $parts = trim(substr($path, strlen(GALLERY_PATH)+1));
    $parts = explode(DIRECTORY_SEPARATOR, $parts);
    
    //var_dump($parts);
    
    $breadcrumb = "<ul class='breadcrumb'>\n<li><a href='?p=gallery'>img</a></li>\n";

    if(!empty($parts[0])) {
      $combine = null;
      foreach($parts as $part) {
        $combine .= ($combine ? '/' : null) . $part;
        $breadcrumb .= "<li> >> <a href='?p=gallery&amp;path={$combine}'>$part</a></li>\n";
      }
    }

    $breadcrumb .= "</ul>\n";
    return $breadcrumb;
}

public function validMovieId($movieid=null)
{
  if($movieid==null)
    return false;
  else
  {
    $sql = "SELECT id,title from movie where id=?";
    $params = array($movieid);
    
    $res = $this->dbh->ExecuteSelectQueryAndFetchAll($sql, $params);
    
    if(count($res)==1)
    {
      $this->title = $res[0]->title;
      $this->id = $res[0]->id;
      return true;
    }
    else
      return false;
  }
}

private function getMovieImages()
{
  
}
  
  
  
}


