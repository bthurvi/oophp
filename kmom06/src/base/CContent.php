<?php


/**
 * 
 * @author urbvik
 */
class CContent
{
  private $cdb = null;
  
  public function __construct($options) 
  {
    $this->cdb = new CDatabase($options);
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
  
  public function add($title, $category, $type, $pdate)
  {
    $sql = "INSERT INTO Content (title, url, category, type, published, created, slug, author, filter) VALUES (?,?,?,?,?,NOW(),?,?,'nl2br')";
    $slug = $this->slugify($title);
    $author = $_SESSION['user']->acronym;
    $ok = $this->cdb->ExecuteQuery($sql, array($title,$slug,$category,$type,$pdate,$slug,$author));
    $this->cdb->SaveDebug();
    
    if($ok)
      return $this->cdb->LastInsertId();
    else 
      return false;
  }
  
  
  public function update($slug, $url, $type, $tite, $data, $filter, $published, $id)
  {
    $sql = 'UPDATE Content SET slug=?,url=?,type=?,title=?,data=?,filter=?,published=?,updated=NOW() WHERE id=?';
    $params = array($slug, $url, $type, $tite, $data, $filter, $published, $id);
    $ok = $this->cdb->ExecuteQuery($sql, $params);
    $this->cdb->SaveDebug();
    
    if($ok)
      return $id;
    else
      return false;
  }
  
  public function delete($id)
  {
     $sql = 'UPDATE Content SET deleted=NOW() WHERE id=?';
    $params = array($id);
    $ok = $this->cdb->ExecuteQuery($sql, $params);
    $this->cdb->SaveDebug();
    
      return $ok;
  }
  
  public function validContentID($id)
  {
    $sql = 'SELECT id from Content';
    $ids = $this->cdb->ExecuteSelectQueryAndFetchAll($sql);
    $this->cdb->SaveDebug();
    
    // is id in resultset?
    $found = false;
    foreach ($ids as $idobj) 
    {
      if($idobj->id==$id)
      {
        $found = true;
        break;
      }
    }
    
   return $found;
  }
  
  
  public function getContent($id)
  {
    if(!$this->validContentID($id))
      return "Invalid id";
    else
    {
      $sql = 'SELECT * from Content WHERE id=?';
      $content = $this->cdb->ExecuteSelectQueryAndFetchAll($sql,array($id));
      $this->cdb->SaveDebug();
      
      return $content;
    } 
  }
  
    /**
   * Create a slug of a string, to be used as url.
   *
   * @param string $str the string to format as slug.
   * @returns str the formatted slug. 
   */
  public function slugify($str) {
    $str = mb_strtolower(trim($str));
    $str = str_replace(array('å','ä','ö'), array('a','a','o'), $str);
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = trim(preg_replace('/-+/', '-', $str), '-');
    return $str;
  }
}
