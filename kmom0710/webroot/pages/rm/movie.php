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
<div id="movie">
    <h2 id="trailer">Trailer:</h2>
<div class="trailer">
  <iframe src="https://www.youtube.com/embed/<?=$res->youtubetrailer;?>?showinfo=0" frameborder="0" allowfullscreen></iframe>
  <h1 class="movietitle"><?=$res->title;?> <span class="movieyear">(<?=$res->year;?>)</span>
  </h1>
</div>

<div>
    <h2>Filminformation:</h2>
    <table class='movieinfo'>
        <tr>
            <td>Längd: <?=$res->length;?> minuter</td>
            <td>Ressigör: <?=$res->director;?></td>
            <td>Undtertext: <?=$res->subtext;?></td>
            <td>Talspråk: <?=$res->speech;?></td>
            <td>Kvalite: <?=$res->quality;?>%</td>
            <td>Media: <?=$res->format;?></td>
            <td><a href='http://www.imdb.com/title/<?=$res->imdblink;?>'>IMDB-länk</a></td>
        </tr>
    </table>
</div>
<div class="movieplot">
    <h2>Handling:</h2>
    <p><?=$res->plot;?></p>
</div>
<h2>Stillbilder:<h2>
<div class="movieimages">
  <img src="<?=$res->image;?>" alt="bild från filmen">
  <img src="<?=$res->image;?>" alt="bild från filmen">
  <img src="<?=$res->image;?>" alt="bild från filmen">
  <img src="<?=$res->image;?>" alt="bild från filmen">
  <img src="<?=$res->image;?>" alt="bild från filmen">
</div>
</div>





