
<h1 class="center">Återställ filmdatabas</h1>
<p>Genom att klicka på knappen nedan återställer du filmdatabasen till sitt ursprung:</p>

<form method="post">
    <input type="submit" value="Återställ databas">
    <input type='hidden' name="restore" /> 
</form>


<?php


 
if(isset($_POST['restore']) || isset($_GET['restore']))
{
     // Restore the database to its original settings via sql-file
    $sql      = 'sql/movieLinux.sql';
    //$sql      = 'sql/test.sql'; //used for testing
    $mysql    = 'mysql';
    $host     = 'blu-ray.student.bth.se';
    $login    = 'urvi15';
    $password = DB_PASSWORD;
    $output = null;
    
    $cmd = "$mysql -h{$host} -u{$login} -p'{$password}' < $sql 2>&1";

    //if windows WAMP-server
  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') 
  {
    $sql      = 'sql/movie.sql';
    $mysql    = 'C:\wamp\bin\mysql\mysql5.6.17\bin\mysql.exe';
    $host     = 'localhost';
    $login    = 'root';
    $password = '';
    $cmd = "$mysql -h{$host} -u{$login} < $sql"; 
  }
  
  $res = exec($cmd);
  //var_dump($res); 
  $output = "<p>Databasen är återställd.</p><p>{$res}</p>";
  echo $output;
  }

  
  
?>



