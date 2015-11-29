<?php

  // Get url param
  $url = isset($_GET['url']) ? $_GET['url'] : null;
  $urlSql = $url ? 'url = ?' : '1';

  // Create and echo page
  $page = new CPage($urbax['database'],$url,$urlSql);
  echo $page->getPage();

?>
