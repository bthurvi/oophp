<?php
  $db = new CDatabase($urbax['database']);
  
  
  
  // Get parameters 
$id     = isset($_POST['id'])    ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
$title  = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$director  = isset($_POST['director']) ? strip_tags($_POST['director']) : null;
$length  = isset($_POST['length']) ? strip_tags($_POST['length']) : null;
$plot  = isset($_POST['plot']) ? strip_tags($_POST['plot']) : null;
$year   = isset($_POST['year'])  ? strip_tags($_POST['year'])  : null;
$subtext   = isset($_POST['subtext'])  ? strip_tags($_POST['subtext'])  : null;
$speech   = isset($_POST['speech'])  ? strip_tags($_POST['speech'])  : null;
$format   = isset($_POST['format'])  ? strip_tags($_POST['format'])  : null;
$quality   = isset($_POST['quality'])  ? strip_tags($_POST['quality'])  : null;
$imdblink  = isset($_POST['imdblink'])  ? strip_tags($_POST['imdblink'])  : null;
$youtubetrailer   = isset($_POST['youtubetrailer'])  ? strip_tags($_POST['youtubetrailer'])  : null;

$image  = isset($_POST['image']) ? strip_tags($_POST['image']) : null;
$genre  = isset($_POST['genre']) ? $_POST['genre'] : array();

$save   = isset($_POST['save'])  ? true : false;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

// if user is NOT authenticated.
if($acronym==null)
{
  $out = <<<EOD
<div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
    <h2 style="margin-top: 0;">Du måste vara inloggad för att få editera</h2>
    <p>Använd menyn uppe till höger på denna sida.</p>
</div>
EOD;
 
  echo $out;
}
 else
 { 


  if($id!=null) // EDIT mode
  {
    //do we have a valid id?
    $sql = "SELECT M.id as id, M.title as title, M.rentalprice as rentalprice,
      M.director as director, M.length as length, M.plot as plot,
      M.year as year, M.subtext as subtext, M.imdblink as imdblink,
      M.youtubetrailer as youtubetrailer, M.image as image,
      M.quality as quality, M.speech as speech, M.format as format,
      GROUP_CONCAT(G.name) AS genre FROM Movie AS M
      LEFT OUTER JOIN Movie2Genre AS M2G
          ON M.id = M2G.idMovie
        INNER JOIN Genre AS G
          ON M2G.idGenre = G.id
          GROUP BY M.id";
    $res = $db->ExecuteSelectQueryAndFetchAll($sql);
    
   

    $movie=null;
    foreach ($res as $mov) 
    {
      if($mov->id == $id)
      {
        $movie = $mov;
      }
    }

    if(!$movie)
        die("CHECK: invalid id");
    
      


    if($save && isset($title) && isset($year))
    {
    $sql = 'UPDATE Movie SET title=?,director=?,length=?,year=?,plot=?,subtext=?,speech=?,format=?,quality=?, imdblink=?, youtubetrailer=? WHERE id=?';
    $params = array($title,$director,$length,$year,$plot,$subtext,$speech,$format,$quality,$imdblink,$youtubetrailer,$id);


    $db->ExecuteQuery($sql, $params);
    
    
    $sql2 = "DELETE FROM movie2genre WHERE idMovie = ?";
    $params = array($movie->id);
    $db->ExecuteQuery($sql2, $params);
    
    
    $sql3 = "INSERT INTO movie2genre(idMovie,idGenre) VALUES ";
   
    $cats = isset($_POST['category'])?$_POST['category']: die("Minst en kategori måste vara vald!");
    $params = null;
    foreach ($cats as $cat) 
    {
      $params[] = $movie->id;
      $params[] = $cat;
      $sql3 .= "(?,?), ";
    }
    $sql3 = rtrim($sql3, ' ');
    $sql3 = rtrim($sql3, ',');
    $sql3 .=';'; 
    
    $db->ExecuteQuery($sql3, $params);
    

    echo  "Informationen sparad. <a href='?p=updatemovie' class='aButton'>Visa alla</a>";
    }
    else
    {
      //output edit form
    $categories = $db->ExecuteSelectQueryAndFetchAll("SELECT * FROM genre");  
    
    echo <<<EEE
    <form method=post id="movieinfoform">
    <h1 style="margin-top: 0;">Ange filminformation</h1>
    <div id='movieinfoformrow1'>
    <input type='hidden' name='id' value='$movie->id'/>
     <div>
      <p><label>Titel:<br/><input type='text' name='title' value='$movie->title'/></label></p>
    </div>
    <div>
      <p><label>Hyrespris:<br/><input type='number' name='rentalprice' value='$movie->rentalprice'/></label></p>
    </div>
    <div>
      <p><label>Ressigör:<br/><input type='text' name='director' value='$movie->director'/></label></p>
    </div>
    <div>
    <p><label>Längd:<br/><input type='number' name='length' value='$movie->length'/></label></p>
    </div>
    </div>
 <p><label>Handling:<br/><textarea name='plot'/>$movie->plot</textarea></label></p>
    <div id="movieinfoformrow3">
      <div>
      <p><label>År:<br/><input type='number' name='year' value='$movie->year'/></label></p>
      </div>
EEE;
    echo "<div><p><label>Textning:<br/>"
    .CHtmlUi::generateSelectList(array('SV','EN','FR','IT','ES'),'subtext',$movie->subtext);
     
    echo "</div><div><p><label>Tal:<br/>"
    .CHtmlUi::generateSelectList(array('SV','EN','FR','IT','ES'),'speech',$movie->speech);
     
    echo "</div><div><p><label>Format:<br/>"
    .CHtmlUi::generateSelectList(array('DVD','VHS','BLR'),'format',$movie->format);
     
    echo "</div><div><p><label>Kvalité:<br/>"
    .CHtmlUi::generateSelectList(array(10,20,30,40,50,50,70,80,90,100),'quality',intval($movie->quality));
     
     echo <<< EEE
    </div><div>
    <p><label>IMDB-länk:<br/><input type='text' name='imdblink' value='$movie->imdblink'/></label></p>
    </div>
    <div>
    <p><label>Youtube-trailer:<br/><input type='text' name='youtubetrailer' value='$movie->youtubetrailer'/></label></p>
    </div>
    </div>
    <div>
      Kategori (en eller flera):
    <div style='padding:10px 0;'>
EEE;
     
     foreach ($categories as $cate) 
     {
       $css = null;
       $checked = null;
       if(in_array($cate->name, explode(',',$movie->genre)))
       {
         $css = "checkedbox";
         $checked = "checked='checked'";
       }
       echo "<div style='display:inline-block; margin-right:10px;'>";
       
       echo "<label class='chtoggle $css'><input type='checkbox' $checked name='category[]' value=$cate->id>";
       echo "<span class='chtogglebox'></span>";
       
       
       echo "<span>$cate->name</span>";
       echo "</label></div>";
     }
    
     echo <<< EEE
     </div>
    </div>
 <p><label>Bild:<br/><input type='text' name='image' value='$movie->image'/></label></p>
    <p><input type='submit' name='save' value='Spara'/> <input type='reset' class='aButton' value='Återställ'/></p>
    <p><a class='aButton' href='?p=updatemovie'>Visa alla</a></p>
    <output></output>
    
  </form>
EEE;
    }
  }
  else // NOT in EDIT mode
  {
    echo "<h1 class='center'>Välj och uppdatera filminformation</h1>";

    echo "<table class='table'>
      <tr><th></th><th>Titel</th><th>Bild</th><th>År</th><th width='10%'>Skapad</th></tr>";

     $sql = "SELECT id,title,image,year, creationdate as tid FROM Movie ORDER BY tid DESC";
    $res = $db->ExecuteSelectQueryAndFetchAll($sql);

    foreach ($res as $i=>$row) 
    {
      echo "<tr>" 
           ."<td width='5%' style='text-align:center;'><a class='aButton' href='?p=updatemovie&amp;id={$row->id}'>editera</a></td>"
           ."<td><strong>{$row->title}</strong></td>"
           . "<td><img src='{$row->image}' alt='bild på film' width='100' height='50'></td>"
           . "<td>{$row->year}</td>"
           . "<td>{$row->tid}</td>"
           . "</tr>";
    }

    echo "</table>";
  }
}
?>






