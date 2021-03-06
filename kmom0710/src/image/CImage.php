<?php


class CImage
{
  private $image_file;
  private $instaniation_file_name;
  private $pathToImage;
  private $verbose = false;
  private $mime;
  private $imgInfo;
  private $image;
  private $attr;
  private $width;
  private $height;
  private $type;
  private $cacheFileName;
  private $pathToCache;
  private $quality;
  private $infoText='';
  private $newWidth;
  private $newHeight;
  
  const MAX_WIDTH = 2000;
  const MAX_HEIGHT = 2000;


  public function __construct($absolute_path_to_image_folder,$path_to_cachie_folder,$image_file,$instaniation_file_name=null, $quality=null, 
          $newWidth=null, $newHeight=null,$cropToFit=null,$sharpen=null,$blackwhite=null, $sepia=null) 
  {  
    //save arguments
    $this->image_file=$image_file;
    $this->instaniation_file_name = $instaniation_file_name;
    $this->pathToCache=$path_to_cachie_folder;
    $this->quality = $quality;
    

    // Validate incoming parameter
    preg_match('#^[a-z0-9A-Z-_\.\/]+$#', $image_file) or $this->errorMessage('Filename contains invalid characters.');
    is_writable($path_to_cachie_folder) or $this->errorMessage('The cache dir is not a writable directory.');
    is_null($quality) or (is_numeric($quality) and $quality > 0 and $quality <= 100) or $this->errorMessage('Quality out of range');
    is_null($quality) or (is_numeric($quality) and $quality > 0 and $quality <= 100) or $this->errorMessage('Quality out of range');
    is_null($newWidth) or (is_numeric($newWidth) and $newWidth > 0 and $newWidth <= CImage::MAX_WIDTH) or $this->errorMessage('Width out of range');
    is_null($newHeight) or (is_numeric($newHeight) and $newHeight > 0 and $newHeight <= CImage::MAX_HEIGHT) or $this->errorMessage('Height out of range');
    is_null($cropToFit) or ($cropToFit and $newWidth and $newHeight) or $this->errorMessage('Crop to fit needs both width and height to work');
   
    
    // Build full path to image
    $this->pathToImage = realpath($absolute_path_to_image_folder . $image_file);
    

    // Validate security for image
    substr_compare($absolute_path_to_image_folder, $this->pathToImage, 0, strlen($absolute_path_to_image_folder)) == 0 
    or $this->errorMessage('Security constraint: Source image must lie DIRECTLY under the image directory.');    // Get information on the image
    $this->imgInfo  = getimagesize($this->pathToImage);
    !empty($this->imgInfo) or errorMessage("The file doesn't seem to be an image.");
    $this->mime = $this->imgInfo['mime'];
    list($this->width,$this->height,$this->type) = getimagesize($this->pathToImage);
    
    
     // Get information on the image
    $this->imgInfo  = getimagesize($this->pathToImage);
    !empty($this->imgInfo) or errorMessage("The file doesn't seem to be an image.");
    $this->mime = $this->imgInfo['mime'];
    list($this->width,$this->height,$this->type) = getimagesize($this->pathToImage);
    
    
    
    //open file
    $this->image = $this->openImage($this->pathToImage);
    
    
   
    //resize or crop image (if needed)
    if ($cropToFit) {
      $this->image = $this->cropImage($this->image, $newWidth, $newHeight);
    } else {
      $this->image = $this->newWidthHeight($this->image, $newWidth, $newHeight);
    }
    
    //sometimes sharpen the image
    if($sharpen){
      $this->image = $this->sharpenImage($this->image);
    }
    
    //sometimes make the image grayscale
    if($blackwhite)
    {
      imagefilter($this->image,IMG_FILTER_GRAYSCALE);
    }
    
    //sometimes make the image sepia
    if($sepia)
    {
      imagefilter($this->image,IMG_FILTER_GRAYSCALE);
      imagefilter($this->image,IMG_FILTER_BRIGHTNESS,-10);
      imagefilter($this->image,IMG_FILTER_CONTRAST,-20);
      imagefilter($this->image,IMG_FILTER_COLORIZE,120,60,0,0);
      $this->image = $this->sharpenImage($this->image);
    }

    //if old internal cashie file - create new one
    $this->cacheFileName = $this->createCasheFilename($path_to_cachie_folder, $quality, $sharpen, $blackwhite, $sepia);
    $imageModifiedTime = filemtime($this->pathToImage);
    $cacheModifiedTime = is_file($this->cacheFileName) ? filemtime($this->cacheFileName) : null;
    if($imageModifiedTime > $cacheModifiedTime)
    {
      $this->infoText .= "None or old cache file - creating new one!<br/>";
      $this->saveToCache($this->image, $this->cacheFileName,$this->quality);
    }
   
  }
  
  /**
  * Create new image and keep transparency
  *
  * @param resource $image the image to apply this filter on.
  * @return resource $image as the processed image.
  */
  private function createImageKeepTransparency($width, $height) 
  {
     $img = imagecreatetruecolor($width, $height);
     imagealphablending($img, false);
     imagesavealpha($img, true);  
     return $img;
 }


  
  
  /**
  * Sharpen image as http://php.net/manual/en/ref.image.php#56144
  * http://loriweb.pair.com/8udf-sharpen.html
  *
  * @param resource $image the image to apply this filter on.
  * @return resource $image as the processed image.
  */
  private function sharpenImage($image) 
  {
    $this->infoText .= "Sharpening the image<br/>";
    
    $matrix = array(
      array(-1,-1,-1,),
      array(-1,16,-1,),
      array(-1,-1,-1,)
    );
    
    $divisor = 8;
    $offset = 0;
    imageconvolution($image, $matrix, $divisor, $offset);
    
    return $image;
  }
  
  private function cropImage($image, $newWidth=null, $newHeight=null)
  {
    $this->infoText .= "Cropping image.<br/>";
    
    $aspectRatio = $this->width / $this->height;
    $targetRatio = $newWidth / $newHeight;
    
    $cropWidth   = $targetRatio > $aspectRatio ? $this->width : round($this->height * $targetRatio);
    $cropHeight  = $targetRatio > $aspectRatio ? round($this->width  / $targetRatio) : $this->height;
    
    $cropX = round(($this->width - $cropWidth) / 2);  
    $cropY = round(($this->height - $cropHeight) / 2);    
    //$imageResized = imagecreatetruecolor($newWidth, $newHeight);
    $imageResized = $this->createImageKeepTransparency($newWidth, $newHeight);
    imagecopyresampled($imageResized, $image, 0, 0, $cropX, $cropY, $newWidth, $newHeight, $cropWidth, $cropHeight);
    
    $this->width = $newWidth;
    $this->height = $newHeight;
    
    return $imageResized;
  }
  
  private function newWidthHeight($image, $newWidth=null,$newHeight=null)
  {
    
    $aspectRatio = $this->width / $this->height;
    
    if($newWidth && !$newHeight) 
    {
      $this->newWidth = $newWidth;
      $this->newHeight = round($newWidth/$aspectRatio);
      $this->infoText .= "New width is known $this->newWidth, height is calculated to $this->newHeight.<br/>"; 
    }
    else if(!$newWidth && $newHeight)
    {
      $this->newHeight = $newHeight;
      $this->newWidth = round($newHeight * $aspectRatio);
      $this->infoText .= "New height is known $newHeight, width is calculated to $newWidth.<br/>"; 
    }
    else if($newWidth && $newHeight) 
   {
      $ratioWidth  = $this->width  / $newWidth;
      $ratioHeight = $this->height / $newHeight;
      $ratio = ($ratioWidth > $ratioHeight) ? $ratioWidth : $ratioHeight;
      $this->newWidth  = round($this->width  / $ratio);
      $this->newHeight = round($this->height / $ratio);
      $this->infoText .= "New width & height is requested, keeping aspect ratio results in {$this->newWidth}x{$this->newHeight}.<br/>"; 
    }
    else 
    {
      $this->newWidth  = $this->width;
      $this->newHeight = $this->height;
      $this->infoText .= "Keeping original width & heigth.<br/>"; 
    }
    
    //create new size of image and return it
    if (!($this->newWidth == $this->width && $this->newHeight == $this->height)) {
      //$imageResized = imagecreatetruecolor($this->newWidth, $this->newHeight);
      $imageResized = $this->createImageKeepTransparency($this->newWidth, $this->newHeight);
      imagecopyresampled($imageResized, $image, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $this->width, $this->height);
      $this->width = $this->newWidth;
      $this->height = $this->newHeight;
      return $imageResized;
    } else {
      $this->infoText .= "Returned same image.<br/>"; 
      return $image;
    }
  }
  
  private function createCasheFilename($cache_path, $quality=null, $cropToFit=null, $sharpen=NULL, $blackwhite=null, $sepia=null)
  {
    //
    // Create a filename for the cache
    $quali   = is_null($quality) ? null : "q{$quality}";
    $sharp       = is_null($sharpen) ? null : "_s";
    $filename = pathinfo($this->image_file, PATHINFO_FILENAME);
    $fileExtension  =  pathinfo($this->image_file,PATHINFO_EXTENSION);
    $crop     = is_null($cropToFit) ? null : "_cf";
    $blackw     = is_null($blackwhite) ? null : "_bw";
    $sep     = is_null($sepia) ? null : "_sep";
    $cacheFileName = $cache_path . $filename. "{$this->width}x{$this->height}{$quali}{$crop}{$sharp}{$blackw}{$sep}.{$fileExtension}";
    $cacheFileName = preg_replace('/^a-zA-Z0-9\.-_/', '', $cacheFileName);
    
    return $cacheFileName;
  }
  
  private function openImage($pathToImage)
  {
    $fileExtension  =  pathinfo($pathToImage,PATHINFO_EXTENSION);
    
    $this->infoText .= "File extension is: $fileExtension<br/>";
    
    //open image
    switch($fileExtension)
    {  
      case 'jpg':
      case 'jpeg': 
        $image = imagecreatefromjpeg($pathToImage);
        $this->infoText .= "Opened the image as a JPEG image<br/>";
        break;  

      case 'png':  
        $image = imagecreatefrompng($pathToImage);  
        $this->infoText .= "Opened the image as a PNG image.<br/>";
        break;  
      
      case 'gif':
        $image = imagecreatefromgif($pathToImage);  
        $this->infoText .= "Opened the image as a GIF image.<br/>";
        break;
         

      default: $this->infoText .= "No support for this file extension.<br/>";    
    }
    
    return $image;   
  }
  
  private function saveToCache($image,$cacheFileName,$quality=100)
  {
    $saveAs  =  pathinfo($cacheFileName,PATHINFO_EXTENSION);
    $this->infoText .= "Saving image to cache <br/>";
    
    switch($saveAs) 
    {
      case 'png':  
        // Turn off alpha blending and set alpha flag
        imagealphablending($image, false);
        imagesavealpha($image, true);
        imagepng($image, $cacheFileName);
        $this->infoText .= "Saved image as PNG to cache <br/>";
        break;
      case 'jpg' :
      case 'jpeg':
        imagejpeg($image, $cacheFileName, $quality);
        $this->infoText .= "Saved image as JPEG to cache using quality = $quality<br/>";
        break;
      case 'gif':

        imagegif($image, $cacheFileName);
        $this->infoText .= "Saved image as GIF to cache <br/>";
        break;
      break;
   
    }
     
  }
 
 
  
  
  public function outputImage($rewriteCashe=false,$verbose=false)
  {
    if($rewriteCashe)
    {
      $this->infoText .= "Forced to rewrite internal cache<br/>";
      $this->cacheFileName = $this->createCasheFilename($this->pathToCache, $this->quality);
      $this->infoText .= $this->openInfo = $this->saveToCache($this->quality);   
    }
    
    //get timestamps for internal and browser cachie 
    $browserCacheTime = null;
    if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) 
      $browserCacheTime = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
    
    
    
    $internalCacheTime = filemtime($this->cacheFileName);
    $gmdate = gmdate("D, d M Y H:i:s", $internalCacheTime);
    
    
    
    if(!$verbose)
    {
      $info = getimagesize($this->cacheFileName);
      !empty($info) or errorMessage("The file doesn't seem to be an image.");
      
      //allvays send modification time
      header('Last-Modified: ' . $gmdate . ' GMT');
       
   
      // has  the browser correct version of the image in cache?
      if($browserCacheTime == $internalCacheTime)
      {
        header('HTTP/1.0 304 Not Modified');
        //var_dump("Browser cache:". $this->cacheFileName);
      }
      else
      {
        header('Content-type: ' . $this->mime);
        readfile($this->cacheFileName);
        //var_dump("Internal cache:".$this->cacheFileName);
      }
    }
    else 
    {
      clearstatcache();
      
      //fetch som info about the image
      $url =  "./img.php" ; 
      parse_str($_SERVER['QUERY_STRING'], $query);
      unset($query['verbose']);
      $url .= '?' . http_build_query($query);
      
      
      $imgInfo =  print_r($this->imgInfo, true);     
      $filesize = filesize($this->pathToImage);
      $memory_peak = round(memory_get_peak_usage() /1024/1024);
      $memory_limit = ini_get('memory_limit');
      $cacheFilesize = filesize($this->cacheFileName);
      $ratio = round($cacheFilesize/$filesize*100);
      
       // has  the browser correct version of th image in cache or not?
      $this->infoText .= "BrowserCacheTime: $browserCacheTime<br/>";
      $this->infoText .= "InternalCacheTime: $internalCacheTime<br/>";
      if($browserCacheTime == $internalCacheTime){ 
        $this->infoText .= "BrowserCache shoud have ben used (304 Not Modified). But we're in werbose mode...<br/>"; }
      else{
        $this->infoText .= "Shoud send header to deliver image with modified time: $gmdate, but we're in verbose mode...";}

      //display information 
      $html = <<<EOD
    <html lang='en'>
    <meta charset='UTF-8'/>
    <title>img.php verbose mode</title>
    <h1>Verbose mode</h1>
    <p>Image file: $this->pathToImage<br/>
    Image information: $imgInfo<br/>
    Image width x height (type): $this->width x $this->height ($this->type)<br/>
    Image file size: $filesize bytes<br/>
    File size of cached file: $cacheFilesize bytes<br/>
    Cache file has a file size of $ratio% of the original size.<br/>
    Image mime type: $this->mime<br/>
    Memory peak:  $memory_peak M<br/>
    Memory limit: $memory_limit<br/>
    Cache file is: $this->cacheFileName<br/>
    $this->infoText
    <h2>Original image:</h2>
    <img src='../img/$this->image_file'>
    <h2>Cache image:</h2>
EOD;
    
      //add link and show ORIGINAL image if possible
      if($this->instaniation_file_name)
      {
        $html .= "<p><a href=$url><code>$url</code></a><br>";
        $html .= "<img src='{$url}' /></p>";
      }
      else
        $html .= "<p>Path to file (img.php ?) using this class neded to display link and image.";
      
      echo $html;

    }
    
  
    
    
     
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
}