<?php 
/**
 * This is a Urbax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 


/*
 * User login
 */
// get filtered input
$acro    = isset($_POST['acronym']) ? (string)filter_input(INPUT_POST, 'acronym',FILTER_SANITIZE_STRING) : null;
$pass    = isset($_POST['password']) ? (string)filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING) : null;
$logout    = isset($_POST['logout']) ? (string)filter_input(INPUT_POST, 'logout',FILTER_SANITIZE_STRING) : null;

//get singelton instance (this only allovs ONE user)
$user = CUser::Instance();

//connect to session and database
$user->Init($urbax['database']);


// If login form is posted - try to login
if($acro && $pass)
{
  $user->Login($acro, $pass);
}
//If logout form is posted - try to logout
if($logout=='Logga ut')
{
  $user->logout();
}

// Set array values (in pagepart-files) before rendering
include "pageparts/behindpage.php";
include "pageparts/header.php";
include "pageparts/footer.php";
include "pageparts/navigation.php";


// Leave it all to the rendering phase of Urbax.
include(URBAX_THEME_PATH);

