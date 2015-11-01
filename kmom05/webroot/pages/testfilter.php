<?php
// Instansierar
$filter = new CTextFilter();
?>


<h3>1. CTextFilter::doFilter():</h3>
<?php
// BBCode
$bbcodetest  = array('Jag vill gärna betona [b]vikten[/b] av detta!','Att göra text [i]kursiv[/i] är enkelt.',
    'u används för att skapa [u]understryken[/u] text.', 'En länk : [url=http://www.bbcode.org/]This be bbcode.org![/url]');

// Konvertera och skriv ut som HTML
echo  $filter->bbcode2html(implode("<br/>",$bbcodetest));
?>


<h3>2.CTextFilter::makeClickable()</h3>
<?php
// Text med länkar i
$linktest = <<<EOD
Några länkar: http://dbwebb.se/coachen/lat-php-funktion-make-clickable-automatiskt-skapa-klickbara-lankar, http://www.bbcode.org/ och https://secure.php.net/manual/en/.
EOD;

// Konvertera och skriv ut som HTML
echo $filter->makeClickable($linktest);
?>


<h3>3. CTextFilter::nl2br()</h3>
<?php
// Text med radbrytningar
$newlinetest = <<<EOD
        Detta
        är
        en text
        som 
        innehåller minst
        tre rader!
EOD;

// Konvertera och skriv ut som HTML
echo $filter->nl2br($newlinetest);
?>


<h3>4.  CTextFilter::markdown():</h3>
<?php
// Markdown
$md = <<<EOD
Detta är ett exempel på markdown
=================================

En länk till [Markdowns hemsida](http://daringfireball.net/projects/markdown/).
EOD;

// Konvertera och skriv ut som HTML
echo $filter->markdown($md);
?>

<h3>5. CTextFilter::doFilter():</h3>
<p>Tillgängliga filter bbcode, clickable, markdown, nl2br och shortcode.
<p>Det filter som appliceras nedan är markdown-filtret.
<?php
// Konvertera och skriv ut som HTML
echo $filter->doFilter($md,'markdown');
?>

<h3>6. Multipla filter med CTextFilter::doFilter()</h3>
<?php
$filtertest  = <<<EOD
Detta är ett exempel på markdown
=================================

En länk till [Markdowns hemsida](http://daringfireball.net/projects/markdown/) 
och en länk till en google-sökning: https://www.google.se/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=markdown 
EOD;

// Konvertera och skriv ut som HTML
echo $filter->doFilter($filtertest,'markdown,clickable');
?>

<h3>Extrauppgift 1:</h3>
<p>Föreslog en utökning av bbcode till att inkludera font-size</p>





