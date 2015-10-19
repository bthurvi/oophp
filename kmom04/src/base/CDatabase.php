<?php



/**
 * Database wrapper, provides a database API for the framework but hides details of implementation.
 *
 * @author urbvik 2015-10-05
 */
class CDatabase {
 
  /**
   * Members
   */
  private $options;                   // Options used when creating the PDO object
  private $db   = null;               // The PDO object
  private $stmt = null;               // The latest statement used to execute a query
  private static $numQueries = 0;     // Count all queries made
  private static $queries = array();  // Save all queries for debugging purpose
  private static $params = array();   // Save all parameters for debugging purpose
  
  
  /**
   * Constructor creating a PDO object connecting to a choosen database.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($options) {
    $default = array(
      'dsn' => null,
      'username' => null,
      'password' => null,
      'driver_options' => null,
      'fetch_style' => PDO::FETCH_OBJ,
    );
    $this->options = array_merge($default, $options);
 
    try {
      $this->db = new PDO($this->options['dsn'], $this->options['username'], $this->options['password'], $this->options['driver_options']);
    }
    catch(Exception $e) {
      //throw $e; // For debug purpose, shows all connection details
      throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
    }
 
    $this->db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $this->options['fetch_style']); 
  }
  
/**
   * Execute a select-query with arguments and return the resultset.
   * 
   * @param string $query the SQL query with ?.
   * @param array $params array which contains the argument to replace ?.
   * @param boolean $debug defaults to false, set to true to print out the sql query before executing it.
   * @return array with resultset.
   */
  public function ExecuteSelectQueryAndFetchAll($query, $params=array(), $debug=false, $asHTMLtable=false,$tableCSSid='') {
 
    self::$queries[] = $query; 
    self::$params[]  = $params; 
    self::$numQueries++;
 
    if($debug) {
      echo "<p>Query = <br/><pre>{$query}</pre></p><p>Num query = " . self::$numQueries . "</p><p><pre>".print_r($params, 1)."</pre></p>";
    }
 
    $this->stmt = $this->db->prepare($query);
    $this->stmt->execute($params);
    
    if($asHTMLtable)
      return $this->generateHTMLtableResult($this->stmt,$tableCSSid);
    else
      return $this->stmt->fetchAll();
    
  }
  
  
  private function generateHTMLtableResult($stmObj,$tableCSSid='')
	{
    if(empty($tableCSSid))
      $html = "<table><tr>";
     else
      $html = "<table id='$tableCSSid'><tr>";

		 //skapar de två första raderna i tabellen rad1= rubriker rad2=data
		 $row = $stmObj->fetch(PDO::FETCH_ASSOC);
		 $rad1="";
		 $rad2="";
		 foreach ($row as $key => $value) 
		 {
		    $rad1 .= "<th>$key</th>";
		    $rad2 .= "<td>$value</td>";
		 }
		 $html .= $rad1 ."<tr>". $rad2 . "</tr>";

		 //fyller på med resten av raderna (om sådana finns)
		 while($row = $stmObj->fetch(PDO::FETCH_ASSOC))
		 {
		    $radx='';
		    $html .= "<tr>";
		    foreach ($row as $key => $value) 
		    	$radx .= "<td>$value</td>";
		    $html .= $radx. "</tr>";
		 }

		$html .= "</table>";
		return $html;
	}
  

 
 
}