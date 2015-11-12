<?php


// Check if user and password is okey
if(isset($_POST['login']))
{
  //build query and array
  $sql = "SELECT acronym, name FROM User WHERE acronym = ? AND password = md5(concat(?, salt))";
  $params = array($_POST['acronym'], $_POST['password']);
  
  // Connect to a MySQL database using PHP PDO
  $db = new CDatabase($urbax['database']);
  
  //run query
   $res = $db->ExecuteSelectQueryAndFetchAll($sql,$params);
   
   
   if(isset($res[0])) 
   {
      $_SESSION['user'] = $res[0];
   }
  
}

  // Check if user is authenticated.
  $acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

   $output ='';
   
  if($acronym) 
  {
    $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
  }
  else 
  {
    $output = "Du är INTE inloggad.";
  }
  
  
 ?>

<div style="max-width: 500px; border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
    <h1 style="margin-top: 0;">Logga in</h1>
  <p>Du kan logga in med doe:doe eller admin:admin.</p>

  <form method="post">
      <p><label>Användare:<br/><input type='text' name='acronym' autofocus="autofocus" value=''/></label></p>
      <p><label>Lösenord:<br/><input type='password' name='password' value=''/></label></p>
 
  <p><input type='submit' name='login' value='Logga in'/><a href="?p=logout" class="aButton" style="display: block; float: right;">Logga ut</a></p>
  </form>
</div>

<output style="margin-left: 20px;"><b><?=$output;?></b></output>
  
  

  


