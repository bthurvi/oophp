<?php
$params[] = isset($_GET['id']) ? $_GET['id'] : 1;

// Connect to a MySQL database using PHP PDO
$db = new CDatabase($urbax['database']);

$query = "SELECT * FROM movie WHERE id=?";
$res = $db->ExecuteSelectQueryAndFetchAll($query, $params);

if(count($res)==1)
  $res=$res[0];
else
  die("Ingen post funnen - felaktigt ID?");


?>

<h1><?=$res->title;?> <span class="movieyear">(<?=$res->year;?>)</span></h1>
<img src="<?=$res->image;?>" alt="bild från filmen"> 
<p>Längd: <?=$res->length;?> minuter</p>
<p>Ressigör: <?=$res->director;?></p>
<p>Undtertexter: <?=$res->subtext;?></p>
<p>Talspråk: <?=$res->speech;?></p>
<p>Kvalite: <?=$res->quality;?>%</p>
<p>Media: <?=$res->format;?></p>


