<?php 
/**
 * This is a Urbax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $urbax variable with its defaults.
include(__DIR__.'/config.php'); 
 
 
// Do it and store it all in variables in the Anax container.
$urbax['title'] = "Slideshow";
 
$urbax['header'] = <<<EOD
<img class='sitelogo' src='img/logo.jpg'  alt='Urbax Logo'/>
<span class='sitetitle'>Urbax webbtemplate</span>
<span class='siteslogan'>Återanvändbara moduler för webbutveckling med PHP</span>q
EOD;
 
$urbax['main'] = <<<EOD
<h1>Ett bildspel med JavaScript</h1>
        
<div id="slideshow" class='slideshow' data-host="" data-path="img/slide/" data-images='["me1.jpg", 
  "me2.jpg", "me3.jpg", "me4.jpg", "me5.jpg", "me6.jpg"]'>
  <img src='img/slide/me6.jpg' width='980' height='300' alt='Me'/>
</div>
<br/>
<p>Detta är en exempelsida som visar att Urbax fungerar med jQuery.</p>

EOD;
 
$urbax['footer'] = <<<EOD
<footer>
  <span class='sitefooter'>Copyright &copy; Urban Vikdahl 2015 | 
    Med utgångspunkt ifrån en mall som skapats av Mikael Roos (me@mikaelroos.se)  | <a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a></span>
</footer>
EOD;
 
 
// Finally, leave it all to the rendering phase of Urbax.
include(URBAX_THEME_PATH);