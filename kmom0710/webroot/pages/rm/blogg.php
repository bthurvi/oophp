
<?php
  
  // Get url params
  $cat  = isset($_GET['cat']) ? $_GET['cat'] : null;
  $slug  = isset($_GET['slug']) ? $_GET['slug'] : null;
  $slugSql = $slug ? 'slug = ?' : '1';
 
 
  // Create and echo page
  $page = new CBlogg($urbax['database'],$slug,$slugSql,$cat);
  echo $page->getPage();

?>
