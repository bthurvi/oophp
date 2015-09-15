<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>PHP oop</title>

	<style>
		body{ margin:0; padding:0; background: #eee; font-family: sans-serif;}
		header{ padding: 30px; background: #005; text-align: center; color: white; font-size: 40px;}
		article{ background: white; padding: 20px;  border-bottom:2px solid #999; }
		article h2{ margin-top: 0px; color: #005;}
	</style>
</head>

<body>

   <?php include "bootstrap.php"; ?>

	<header>
	<h1>20 steg i objekorientering med PHP</h1>
	</header>

	<article>
	<h2>Steg 1 - intro teori</h2>
	<p>Läste på om begreppen: objekt, metod, egenskaper/properties och inkapsling.
	<p>Slår på all error-reporting för php
	<?php error_reporting(E_ALL); ini_set('display_errors', '1'); ?>
	</article>

	<article>
	<h2>Steg 2 - att använda en enkel klass</h2>
	<p>
	<?php 
		$sp = new SimpleClass();
		$sp->DisplayVar();
		$sp->var="a new value";
		echo "<p>";
		$sp->DisplayVar();
	?>
	</article>

	<article>
	<h2>Steg 3 - en tärningsklass</h2>
	<p>Simulera tärningsslag genom att ange ett värde för GET-parametern <strong>rolls</strong>
	<?php
		$d = new CDice();

		if(isset($_GET['rolls']))
		{
			$n = (int)filter_input(INPUT_GET, 'rolls');
			echo "<p>Slår tärningen $n gånger";
			$d->RollDice($n);
			echo '<p> Resultat:' . $d->GetRolls();
			echo '<p> Summa: ' . $d->GetSum();
			echo '<p> Medelvärde: ' . $d->GetAverage();
		}
	?>
	</article>

	<article>
	<h2>Steg 4 - klasser i separata filer</h2>
	<p>Frekvensdiagram över den senaste omgången tärningsslag:
	<?php 
		$hist = new CHistogram();
		$freq = $hist->GetHistogram($d->results);
		foreach ($freq as $key => $value) {
			echo "<br />$key : $value";
		}
	?>
	</article>

	<article>
	<h2>Steg 5 - autoload av klassfiler</h2>
	<p>Tog bort includes och ersatte med autoload (i början av denna fil).
	</article>

</body>
</html>