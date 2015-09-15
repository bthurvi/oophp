<?php

echo "Hello from bootstap";

function myAutoloader($class) {
  $path = "{$class}.php";
  if(is_file($path)) {
    include($path);
  }
}

spl_autoload_register('myAutoloader');