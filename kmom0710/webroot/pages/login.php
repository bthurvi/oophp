<?php
// get filtered input
$acro    = isset($_POST['acronym']) ? (string)filter_input(INPUT_POST, 'acronym',FILTER_SANITIZE_STRING) : null;
$pass    = isset($_POST['password']) ? (string)filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING) : null;

//get singelton instance (this only allovs ONE user)
$user = CUser::Instance();

//connect to session and database
$user->Init($urbax['database']);


// If form is posted - try to login
if($acro && $pass)
{
  $user->Login($acro, $pass);
}
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

<?php
$user->PrintAuthInfo();
?>




