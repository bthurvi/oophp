
<?php
  // Get parameters for sorting
  $title = isset($_POST['title']) ? $_POST['title'] : null;
  
  
  //Connect to database
  $db = new CDatabase($urbax['database']);
 

  // SELECT from a table
  if($title) 
  {
    // prepare SQL for search
    $sql = "SELECT * FROM Movie WHERE title LIKE ?;";
    $params = array("%$title%"); 
  }
  else {
    // prepare SQL to show all
    $sql = "SELECT id,title,image,year FROM Movie";
    $params = null;
  }
?>


<h1 class="center">Sök efter en film </h1>


<form method="post">
    <p><label>Titel (eller del av titel): <input type='search' autofocus="autofocus" name='title' value='<?=$title?>'/></label></p>
</form>

<p><a href='?p=movietitlesearch' class='aButton'>Visa alla</a></p>

<table class='table'>
  <tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>

  <?php
  $res = $db->ExecuteSelectQueryAndFetchAll($sql,$params);
  
  foreach ($res as $i=>$row) 
  {
    echo "<tr><td>$i</td><td>{$row->id}</td><td><img src='{$row->image}' alt='bild på film' width='100' height='50'></td><td>{$row->title}</td><td>{$row->year}</td></tr>";
  }
?>
</table>



