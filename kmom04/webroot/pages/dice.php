<?php 

// Demonstration of module CDice
$dice = new CDice();

$roll = isset($_GET['roll']) && is_numeric($_GET['roll']) ? $_GET['roll'] : 0;

if($roll > 100) {
  throw new Exception("To many rolls on the dice. Not allowed.");
}

$html = null;
if($roll) {
  $dice->Roll($roll);

  $html = "<p>Du gjorde {$roll} kast och fick följande resultat:</p>\n<ul>";
  foreach($dice->GetResults() as $val) {
    $html .= "\n<li style='list-style-type:none;'>{$val}</li>";
  }
  $html .= "\n</ul>\n";

  $html .= "<p>Totalt fick du " . $dice->GetTotal() . " poäng på dina kast.</p>";
}
?>


<h1 class="center">Kasta tärning</h1>
<p class="center">Detta är en exempelsida som visar hur Urbax fungerar tillsammans med återanvändbara moduler.</p>
<div style="text-align: center">
<p >Hur många kast vill du göra, <a href='?p=dice&roll=1'>1 kast</a>, <a href='?p=dice&roll=3'>3 kast</a> eller <a href='?p=dice&roll=6'>6 kast</a>? </p>

<?=$html;?>
</div>



