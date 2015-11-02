<?php


/**
 * 
 * @author urbvik
 */
class CContent
{
  private $cdb = null;
  
  public function __construct() 
  {
    $cdb = new CDatabase();
  }
  
  /**
   * Reset - En metod som kan skapar och fyller de nödvändiga tabellerna.
   */
  public function reset()
  {
    
      // Restore the database to its original settings via sql-file
     $sql      = 'sql/contentLinux.sql';
     $mysql    = 'mysql';
     $host     = 'blu-ray.student.bth.se';
     $login    = 'urvi15';
     $password = 'Py-5t1Q;';
     $output = null;
     $cmd = "$mysql -h{$host} -u{$login} -p'{$password}' < $sql 2>&1";

      //if windows WAMP-server
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') 
    {
      $sql      = 'sql/content.sql';
      $mysql    = 'C:\wamp\bin\mysql\mysql5.6.17\bin\mysql.exe';
      $host     = 'localhost';
      $login    = 'root';
      $password = '';
      $cmd = "$mysql -h{$host} -u{$login} < $sql"; 
    }
    

    $res = exec($cmd);
    return "<p>Databasen är återställd.</p><p>{$res}</p>";
  }
  
  public function add()
  {
    
  }
  
  
  public function edit()
  {
    
  }
  
  public function remove()
  {
    
  }
  
}
