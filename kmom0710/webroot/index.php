<?php 
/**
 * This is a Urbax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 

// Set array values (in pagepart-files) before rendering
include "pageparts/behindpage.php";
include "pageparts/header.php";
include "pageparts/footer.php";
include "pageparts/navigation.php";


// Leave it all to the rendering phase of Urbax.
include(URBAX_THEME_PATH);

