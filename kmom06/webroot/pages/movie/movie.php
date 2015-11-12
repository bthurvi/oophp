
<h1 class="center">Koppla upp php PDO mot MySQL</h1>
<p class="center">Alla filmer i databasen:</p>

<?php
  $db = new CDatabase($urbax['database']);
  
  $sql = "SELECT id,title,image,year FROM Movie";
  $res = $db->ExecuteSelectQueryAndFetchAll($sql);
  
 ?>

<table class='table'>
  <tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>

  <?php
  foreach ($res as $i=>$row) 
  {
    echo "<tr><td>$i</td><td>{$row->id}</td><td><img src='{$row->image}' alt='bild på film' width='100' height='50'></td><td>{$row->title}</td><td>{$row->year}</td></tr>";
  }
?>
</table>



