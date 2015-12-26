<?php
$params[] = isset($_GET['id']) ? $_GET['id'] : 1;

// Connect to a MySQL database using PHP PDO
$db = new CDatabase($urbax['database']);

$query = "SELECT GROUP_CONCAT(oophp0710_images.image)as images,title,director,length,year,plot,subtext,speech,quality,format,rentalprice,imdblink,youtubetrailer FROM oophp0710_movie INNER JOIN oophp0710_movie2image INNER JOIN oophp0710_images ON oophp0710_movie.id=oophp0710_movie2image.movie_id AND oophp0710_images.id=oophp0710_movie2image.image_id WHERE oophp0710_movie.id=?;";


$res = $db->ExecuteSelectQueryAndFetchAll($query, $params);


if(count($res)==1)
  $res=$res[0];
else
  die("Ingen post funnen - felaktigt ID?");


?>
<div id="movie">
    <h2 id="trailer">Trailer:</h2>
<div class="trailer">
  <iframe src="https://www.youtube.com/embed/<?=$res->youtubetrailer;?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
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

<?php 
    if(!is_null($res->images))
    {
      echo "<h2>Stillbilder:<h2>";
      echo "<div class='movieimages'>";
      
      $images = explode(',',$res->images);
      
      foreach($images as $image)
      {
        $file=basename($image);
        echo "<a href='pages/img.php?src=movie/$file'>";
        $src = "src='pages/img.php?src=movie/$file";
        $src .= "&amp;";
        $src .= "width=330";
        $src .= "&amp;";
        $src .= "height=200";
        $src .= "&amp;";
        $src .= "crop-to-fit'";
              
        echo "<img $src alt='bild från filmen'>";
        echo "</a>";
      }
      
      echo "</div>";
    }
    
    
    
?>

</div>





