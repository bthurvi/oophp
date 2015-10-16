
<h1 class="center">Filmdatabas</h1>
<p class="center">Detta är en exempelsida för filmdatabasen.</p>

<?php
  $db = new CDatabase($urbax['database']);
  
  $sql = "SELECT * FROM Movie";
  echo $db->ExecuteSelectQueryAndFetchAll($sql,array(),false,true);
?>



