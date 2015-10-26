<?php
// ADD FILTER INPUT!
$user    = isset($_GET['acronym']) ? $_GET['acronym'] : null;
$pass    = isset($_GET['password']) ? $_GET['password'] : null;

// Check that incoming parameters are valid
//is_string($user) or die('Check: User must be string.');
//is_string($pass) or die('Check: Pass must be numeric.');
?>


<div class='searchpanel'>
    <h1 style="margin-top: 0;">Logga in</h1>
  <p>Du kan logga in med doe:doe eller admin:admin.</p>

  <form method="post">
      <p><label>Användare:<br/><input type='text' name='acronym' autofocus="autofocus" value=''/></label></p>
      <p><label>Lösenord:<br/><input type='password' name='password' value=''/></label></p>
 
  <p><input type='submit' name='login' value='Logga in'/></p>
  </form>
</div>




