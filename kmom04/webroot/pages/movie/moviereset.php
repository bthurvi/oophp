
<h1 class="center">Återställ filmdatabas</h1>
<p>Genom att klicka på knappen nedan återställer du filmdatabasen till sitt ursprung:</p>
<p class="center">
  <form method="post">
      <input type="submit" value="Återställ databas">
      <input type='hidden' name="restore" /> 
  </form>
</p>

<?php


 
if(isset($_POST['restore']) || isset($_GET['restore']))
{
     // Restore the database to its original settings via movi.sql-file
    $sql      = 'sql/movie.sql';
    $mysql    = '/usr/local/bin/mysql';
    $host     = 'localhost';
    $login    = 'acronym';
    $password = 'password';
    $output = null;
    
    $cmd = "$mysql -h{$host} -u{$login} -p{$password} < $sql 2>&1";

    //if windows WAMP-server
  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') 
  {
    $mysql    = 'C:\wamp\bin\mysql\mysql5.6.17\bin\mysql.exe';
    $login    = 'root';
    $password = '';
    $cmd = "$mysql -h{$host} -u{$login} < $sql"; 
  }
  
  $res = exec($cmd);
  $output = "<p>Databasen är återställd via kommandot<br/><code>{$cmd}</code></p><p>{$res}</p>";
  echo $output;
  }

  
  
?>



