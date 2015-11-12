<?php


class CImage
{
  private $image_file;
  private $instaniation_file_name;
  private $pathToImage;
  private $verbose = false;
  private $mime;
  private $imgInfo;
  private $attr;
  
  public function __construct($absolute_path_to_image_folder, $image_file, $instaniation_file_name=null) 
  {  
    //save arguments
    $this->image_file=$image_file;
    $this->instaniation_file_name = $instaniation_file_name;

    // Validate incoming parameter
    preg_match('#^[a-z0-9A-Z-_\.\/]+$#', $image_file) 
    or 
    $this->errorMessage('Filename contains invalid characters.');
    
    // Build full path to image
    $this->pathToImage = realpath($absolute_path_to_image_folder . $image_file);
    

    // Validate security for image
    substr_compare($absolute_path_to_image_folder, $this->pathToImage, 0, strlen($absolute_path_to_image_folder)) == 0 
    or 
    $this->errorMessage('Security constraint: Source image must lie DIRECTLY under the image directory.');
    
    
    // Get information on the image
    $this->imgInfo  = getimagesize($this->pathToImage);
    !empty($this->imgInfo) or errorMessage("The file doesn't seem to be an image.");
    $this->mime = $this->imgInfo['mime'];
    
  }
  
  
  public function outputImage($verbose= false)
  {
    if(!$verbose)
    {
      header('Content-type: ' . $this->mime);  
      readfile($this->pathToImage);
    }
    else 
    {
      //fetch som info about the image
      $url =  './img.php?src=' . $this->image_file; 
      $imgInfo =  print_r($this->imgInfo, true);
      list($width,$height,$type) = getimagesize($this->pathToImage);
      $filesize = filesize($this->pathToImage);
      $memory_peak = round(memory_get_peak_usage() /1024/1024);
      $memory_limit = ini_get('memory_limit');

      //display information 
      $html = <<<EOD
    <html lang='en'>
    <meta charset='UTF-8'/>
    <title>img.php verbose mode</title>
    <h1>Verbose mode</h1>
    <p>Image file: $this->pathToImage</p>
    <p>Image information: $imgInfo</p>
    <p>Image width x height (type): $width x $height ($type)</p>
    <p>Image file size: $filesize bytes</p>
    <p>Image mime type: $this->mime</p>
    <p>Memory peak:  $memory_peak M</p>
    <p>Memory limit: $memory_limit</p>
EOD;
    
      //add link and show image if possible
      if($this->instaniation_file_name)
      {
        $html .= "<p><a href=$url><code>$url</code></a><br>";
        $html .= "<img src='{$url}' /></p>";
      }
      else
        $html .= "<p>Path to file (img.php ?) using this class neded to display link and image.";

    }
    
    echo $html;
     
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