<?php


// get parameters
$create   = isset($_POST['create'])  ? true : false;
$title  = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$category  = isset($_POST['category']) ? strip_tags($_POST['category']) : null;
$type   = isset($_POST['type'])  ? strip_tags($_POST['type'])  : null;
$pdate   = isset($_POST['pdate'])  ? $_POST['pdate']  : null;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

// if user is NOT authenticated.
if($acronym==null)
{
  echo <<< EOD
<div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
    <h2 style="margin-top: 0;">Du måste vara inloggad för att få skapa nytt innehåll...</h2>
    <p><a href="?p=clogin" class="aButton">Logga in</a></p>
</div>
EOD;
 
}
else
{
   if($create) 
  {
     $cont = new CContent($urbax['database']); 
     if($newId = $cont->add($title,$category,$type,$pdate))
     {
      echo  "Nytt innehåll sparat. <a href='?p=uppdatecontent&amp;id=$newId' class='aButton'>Editera</a>";
      
     //use javascritp to redirect - forces the the nav menu to uppdate
     echo "<script> setTimeout(function (){ window.location.href = '?p=contentedit'; }, 2000);</script>";
  
     }
  }
  else
  {
    $today =  date("Y-m-d");
    
    //var_dump($user->isAdmin());
    $disabled='';
    $info='';
    if(!$user->isAdmin())
    {
      $disabled = "disabled";
      $info = "<p> Du kan inte editera eftersom du inte är administratör.</p>";
    }
    
echo <<< MYHTML
 <div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
  <h1 class="center">Lägg till innehåll</h1>
  <form method=post $disabled>
       <p><label>Typ av innehåll:
          <select required="required" name='type' style=' width:228px; padding:2px;' $disabled>
              <option value="post">post</option>
              <option value="page">page</option>
          </select>
       </label></p>
       <p><label>Kategori: <input type='text'required="required" value='standard-information' style='width:266px; padding:2px;' name='category' $disabled/></label></p>
       <p><label>Titel: <input type='text' required="required" autofocus='autofocus' style='width:296px; padding:2px;' name='title' $disabled/></label></p>
       <p><label>Publiceringsdatum: <input type='date' required="required" value='{$today}' style='width:194px;' name='pdate' $disabled/></label></p>
    <p><input type='submit' name='create' value='Skapa' $disabled/></p>
  </form>
</div>
$info
MYHTML;
  }
}





