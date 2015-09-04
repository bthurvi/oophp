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
 *
 */
function myAutoloader($class) {
  $path = URBAX_INSTALL_PATH . "/src/{$class}/{$class}.php";
  if(is_file($path)) {
    include($path);
  }
  else {
    throw new Exception("Classfile '{$class}' does not exists.");
  }
}

//this is where the magic happends 
// as I understand it all the classes are loaded by the callback function
spl_autoload_register('myAutoloader');


//the famous function dump - used for printing/debugging arrays
function dump($array) 
{
  echo "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}