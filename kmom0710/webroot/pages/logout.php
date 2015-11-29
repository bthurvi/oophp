<?php
//get singelton instance (this only allovs ONE user)
$user = CUser::Instance();

//connect to session and database
$user->Init($urbax['database']);


// If form is posted - try to login
if(isset($_POST['logout']))
{
  $user->Logout();
}
?>


<div class='searchpanel'>
    <h1 style="margin-top: 0;">Logga ut</h1>
  <form method="post">
  <p><input type='submit' name='logout' value='Logga ut'/></p>
  </form>
</div>

<?php
$user->PrintAuthInfo();
?>

