
<?php
  
  // Get url param
  $slug  = isset($_GET['slug']) ? $_GET['slug'] : null;
  $slugSql = $slug ? 'slug = ?' : '1';
 
 
  // Create and echo page
  $page = new CBlogg($urbax['database'],$slug,$slugSql);
  echo $page->getPage();

?>
