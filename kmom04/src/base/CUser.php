<?php



/**
 * @author urbvik
 *
 * CUser is a singelton - use CUser::Instance() to create object
 * 
 */
class CUser 
{
 private $db;
 private $acronym;
 private $name;
 
 private static $instance = null;
 
 //instance
 public static function Instance()
 { 
   return is_null(self::$instance) ? self::$instance = new self : self::$instance;
 }


 //constructor
 private function __construct()
 {
    /*new session - if we do not have one...
   if (session_status() == PHP_SESSION_NONE) 
   {
      session_start();            
   }

    //if we have user data in session - load it
    if(isset($_SESSION['user']))
    {
       $this->acronym = $_SESSION['user']->acronym;
       $this->name = $_SESSION['user']->name;
    }
    else
    {
      $this->acronym = null;
      $this->name = null;
    }
   

    // Connect to a MySQL database using PHP PDO
    $this->db = new CDatabase($dbConSetArr);*/
    
 }
 
 // setup - start session, get data from session (if possible) and connect to database
 public function init($dbConSetArr)
 {
    //new session - if we do not have one...
   if (session_status() == PHP_SESSION_NONE) 
   {
      session_start();            
   }

    //if we have user data in session - load it
    if(isset($_SESSION['user']))
    {
       $this->acronym = $_SESSION['user']->acronym;
       $this->name = $_SESSION['user']->name;
    }
    else
    {
      $this->acronym = null;
      $this->name = null;
    }
   

    // Connect to a MySQL database using PHP PDO
    $this->db = new CDatabase($dbConSetArr);
    
 }
  
  //logs in - if user and passs is correct
 public function Login($user, $password)
 {  
     //build query and array
    $sql = "SELECT acronym, name FROM User WHERE acronym = ? AND password = md5(concat(?, salt))";
    $params = array($user, $password);

    //run query
     $res = $this->db->ExecuteSelectQueryAndFetchAll($sql,$params);

     //login - success!
     if(isset($res[0])) {
      $_SESSION['user'] = $res[0];
       $this->acronym = $res[0]->acronym;
      $this->name = $res[0]->name;
    }

 }    

 // logs off user    
 public function Logout() 
 {
   unset($_SESSION['user']);
 } 

 // returns true or false
 public function IsAuthenticated()
 {
   $acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

    if($acronym) 
    {
      $this->IsAuthenticated = true;
    }
    else 
    {
      $this->IsAuthenticated = false;
    }
    
    return $this->IsAuthenticated;
 } 

 // retrun user acronym
 public function GetAcronym() 
 {
    return  $this->acronym;
 } 

 // return user name
 public function GetName() 
 {
    return  $this->name;
 }
 
 public function PrintAuthInfo() 
 {
   if($this->IsAuthenticated())
      echo "Du är inloggad som: <b>" . $this->GetAcronym() . "</b> (" . $this->GetName() . ")";
    else
      echo "Du är <b>UTLOGGAD</b>.";
 }

}
