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
      echo  "Nytt innehåll sparat. <a href='?p=contentedit&amp;id=$newId' class='aButton'>Editera</a>";
  }
  else
  {
    $today =  date("Y-m-d");
echo <<< MYHTML
 <div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
  <h1 class="center">Lägg till innehåll</h1>
  <form method=post>
       <p><label>Typ av innehåll:
          <select equired="required" name='type' style=' width:228px; padding:2px;'>
              <option value="post">post</option>
              <option value="page">page</option>
          </select>
       </label></p>
       <p><label>Kategori: <input type='text'required="required" value='standard-information' style='width:266px; padding:2px;' name='category'/></label></p>
       <p><label>Titel: <input type='text' required="required" autofocus='autofocus' style='width:296px; padding:2px;' name='title'/></label></p>
       <p><label>Publiceringsdatum: <input type='date' required="required" value='{$today}' style='width:194px;' name='pdate'/></label></p>
    <p><input type='submit' name='create' value='Skapa'/></p>
  </form>
</div>
MYHTML;
  }
}





