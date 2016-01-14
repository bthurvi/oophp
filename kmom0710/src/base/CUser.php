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
 private $role;
 
 private $IsAuthenticated = null;
 private $IsAdmin = null;
 
 
 public $status=null;
 
 private static $instance = null;
 
 //instance
 public static function Instance()
 { 
   return is_null(self::$instance) ? self::$instance = new self : self::$instance;
 }
 
 public function isUsernameAvaliable($name)
 {
   $sql = "SELECT acronym FROM oophp0710_user WHERE acronym=?";
   $params = array($name);
   
    $res = $this->db->ExecuteSelectQueryAndFetchAll($sql,$params);
    
    if(count($res)<1)
      return true;
    else
      return false;
 }
 
 public function addUser($username,$password)
 {
   $sql = "INSERT INTO oophp0710_user (role,acronym, name, salt) VALUES ('usr',?,?, unix_timestamp())";
   $params = array($username,$username);
   $this->db->ExecuteQuery($sql,$params);
   
   $sql = "UPDATE oophp0710_user SET password = md5(concat(?, salt)) WHERE acronym = ?";
   $params = array($password,$username);
   $this->db->ExecuteQuery($sql,$params);
   
   
   $sql = "SELECT id FROM oophp0710_user WHERE acronym = ?";
   $params = array($username);
   $this->db->ExecuteQuery($sql,$params);
   $res = $this->db->ExecuteSelectQueryAndFetchAll($sql,$params);
    
    if(count($res)==1)
      return true;
    else
      return false;
 }


 // disable constructor
 private function __construct(){}
 
 /*
  *  setup - use this as constructor
  * 
  *  starts a session, get data from session (if possible) and connect to database
  */
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
 
 


  
 /*
  * logs in - if user and passs is correct
  */
 public function Login($user, $password)
 {  
     //build query and array
    $sql = "SELECT role,acronym,name,intrests,music,books,favoritemovie FROM oophp0710_user WHERE acronym = ? AND password = md5(concat(?, salt))";
    $params = array($user, $password);

    //run query
     $res = $this->db->ExecuteSelectQueryAndFetchAll($sql,$params);

     //login - success!
     if(isset($res[0])) {
      $_SESSION['user'] = $res[0];
       $this->acronym = $res[0]->acronym;
       $this->name = $res[0]->name;
       $this->role = $res[0]->role;
    }
    else
    {
      $this->status = "<span style='color:red;'>Felaktigt användarnamn eller lösenord.</span>";
    }

 }    

 /*
  *  logs off user    
  */
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
 
 // returns true or false
 public function IsAdmin()
 {
   $role = isset($_SESSION['user']) ? $_SESSION['user']->role : null;

    if($role=="adm") 
    {
      $this->IsAdmin = true;
    }
    else 
    {
      $this->IsAdmin = false;
    }
    
    return $this->IsAdmin;
 }

 /*
  * retrun user acronym
  */
 public function GetAcronym() 
 {
    return  $this->acronym;
 } 

 /*
  *  return user name
  */
 public function GetName() 
 {
    return  $this->name;
 }
 
 /*
  *  print if user is logged in or not
  */
 public function PrintAuthInfo() 
 {
   if($this->IsAuthenticated())
      echo "Du är inloggad som: <b>" . $this->GetAcronym() . "</b> (" . $this->GetName() . ")";
    else
      echo "Du är <b>UTLOGGAD</b>.";
 }

}
