<?php
/**
 * Bootstrapping functions, essential and needed for Urbax to work together with some common helpers. 
 *
 */
 
/**
 * Default exception handler.
 *
 */
function myExceptionHandler($exception) {
  echo "Urbax: Uncaught exception: <p>" . $exception->getMessage() . "</p><pre>" . $exception->getTraceAsString(), "</pre>";
}
set_exception_handler('myExceptionHandler');
 
 
/**
 * Autoloader for classes.
 */

function myAutoloader($class) 
{
  //$class = ucfirst($class);
  
  $path1 = URBAX_INSTALL_PATH . "/src/base/{$class}.php";
  $path2 = URBAX_INSTALL_PATH . "/src/dice/{$class}.php";
  $path3 = URBAX_INSTALL_PATH . "/src/calendar/{$class}.php";
  $path4 = URBAX_INSTALL_PATH . "/src/dicegame/{$class}.php";
  
  if(is_file($path1)) {include($path1);}
  else if(is_file($path2)) {include($path2);}
  else if(is_file($path3)) {include($path3);}
  else if(is_file($path4)) {include($path4);}
  else {throw new Exception("Classfile '{$path1},{$path2}, {$path3} or {$path4}' does not exists.");}
}


//this is where the magic happends 
// as I understand it all the classes are loaded by the callback function
spl_autoload_register('myAutoloader');


//the famous function dump - used for printing/debugging arrays
function dump($array) 
{
  echo "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}



// -------------------------------------------------------------------------------------------
//
// Destroy a session
//
function destroySession() {
  // Unset all of the session variables.
  $_SESSION = array();
  
  // If it's desired to kill the session, also delete the session cookie.
  // Note: This will destroy the session, and not just the session data!
  if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
      );
  }
  
  // Finally, destroy the session.
  session_destroy();
}





