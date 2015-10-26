<?php



/**
 * @author urbvik
 */
class CUser 
{
 private $db;
 private $acronym;
 private $name;
 
 //constructor
 public function __construct($dbConSetArr)
 {
    //new session - if we do not have one...
   if (session_status() == PHP_SESSION_NONE) 
   {
     
      session_start();            
      $this->acronym = null;
      $this->name = null;
   }

    //if we have user data in session - load it
    if(isset($_SESSION['user']))
    {
       $this->acronym = $_SESSION['user']->acronym;
       $this->name = $_SESSION['user']->name;
    }
   

    // Connect to a MySQL database using PHP PDO
    $db = new CDatabase($dbConSetArr);
    
    
 }
  
  //logs in - if user and passs is correct
 public function Login($user, $password)
 {  
     //build query and array
    $sql = "SELECT acronym, name FROM User WHERE acronym = ? AND password = md5(concat(?, salt))";
    $params = array($acronym, $password);

    //run query
     $res = $db->ExecuteSelectQueryAndFetchAll($sql,$params);

     var_dump($res);

     if(isset($res[0])) {
      $_SESSION['user'] = $res[0];
    }

 }    

 // logs off user    
 public function Logout() 
 {

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
      echo "Du är INTE inloggad.";
 }

}
