<?php


// Prepare the content
$html = <<<EOD
Detta är ett exempel på markdown
=================================

En länk till [Markdowns hemsida](http://daringfireball.net/projects/markdown/).

EOD;



// Filter the content
$filter = new CTextFilter();
$html = $filter->doFilter($html, "markdown");


// Print content
echo $html;



