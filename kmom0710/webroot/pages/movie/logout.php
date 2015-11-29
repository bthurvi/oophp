<?php

// Logout the user
if(isset($_POST['logout'])) 
{
  unset($_SESSION['user']);
}

// Check if user is authenticated.
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

  if($acronym) {
    $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
  }
  else {
    $output = "Du är INTE inloggad.";
  }

  
  
  
 ?>

<div style="max-width: 500px; border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
    <h1 style="margin-top: 0;">Logga ut</h1>

  <form method="post">
      <p><input type='submit' name='logout' value='Logga ut' /><a href="?p=login" class="aButton" style="display: block; float: right;">Logga in</a></p>
  </form>
</div>

<output style="margin-left: 20px;"><b><?=$output;?></b></output>
  
  

  


