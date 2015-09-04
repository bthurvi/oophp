<?php 
/**
 * This is a Urbax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $urbax variable with its defaults.
include(__DIR__.'/config.php'); 
 
 
// Do it and store it all in variables in the Anax container.
$urbax['title'] = "Hello World";
 
$urbax['header'] = <<<EOD
<img class='sitelogo' src='img/logo.jpg' alt='Urbax Logo'/>
<span class='sitetitle'>Urbax webbtemplate</span>
<span class='siteslogan'>Återanvändbara moduler för webbutveckling med PHP</span>
EOD;
 
$urbax['main'] = <<<EOD
<h1>Hej Världen!</h1>
<p>Detta är en exempelsida som visar hur Urbax ser ut och fungerar.</p>
EOD;
 
$urbax['footer'] = <<<EOD
<footer>
  <span class='sitefooter'>Copyright &copy; Urban Vikdahl 2015 | 
    Med utgångspunkt ifrån en mall som skapats av Mikael Roos (me@mikaelroos.se)  | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a></span>
</footer>
EOD;
 
 
// Finally, leave it all to the rendering phase of Urbax.
include(URBAX_THEME_PATH);