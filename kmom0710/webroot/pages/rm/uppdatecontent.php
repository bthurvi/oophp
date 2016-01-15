<?php

// get parameters
$id   = isset($_GET['id'])  ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE):null;
$uppdate   = isset($_POST['uppdate'])  ? true : false;
$title  = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$type   = isset($_POST['type'])  ? strip_tags($_POST['type'])  : null;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;


$cont = new CContent($urbax['database']); 



if($acronym==null)// if user is NOT authenticated.
{
  echo <<< EOD
<div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
    <h2 style="margin-top: 0;">Du måste vara inloggad för att få redigera innehåll...</h2>
    <p><a href="?p=clogin" class="aButton">Logga in</a></p>
</div>
EOD;
 
}
else //user is authorized
{
  //Do we have a valid id-value?
  if(!$cont->validContentId($id))
  { 
    $dbc = new CDatabase($urbax['database']);
    $resultset = $dbc->ExecuteSelectQueryAndFetchAll("SELECT id, title FROM oophp0710_content WHERE deleted IS NULL and type='post'");

    echo "<h2>Välj post att redigera:</h2>";

    echo "<table class='table'>";
    echo "<tr><th style='width:100px;'></th><th>Id</th><th>Titel</th></tr>";
    foreach ($resultset as $res) 
    {
      echo "<tr><td><a href='?p=uppdatecontent&amp;id={$res->id}' class='aButton' style='width:50px; margin:0 auto; display:block;'>Editera</a></td><td>{$res->id}</td><td>{$res->title}</td></tr>";
    }
    echo "</table>";
  }
   else
   {
 
     if($uppdate) // Save uppdate
    {
       // Get parameters 
      $id     = isset($_POST['id'])    ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
      $title  = isset($_POST['title']) ? $_POST['title'] : null;
      $slug   = isset($_POST['slug'])  ? $_POST['slug']  : null;
      $url    = isset($_POST['url'])   ? strip_tags($_POST['url']) : null;
      $data   = isset($_POST['data'])  ? $_POST['data'] : array();
      $type   = isset($_POST['type'])  ? strip_tags($_POST['type']) : array();
      $filter = isset($_POST['filter']) ? $_POST['filter'] : array();
      $published = isset($_POST['published'])  ? strip_tags($_POST['published']) : array();

       if($updatedId = $cont->update($slug, $url, $type, $title, $data, $filter, $published, $id))
       {
        echo  "Innehåll uppdaterat.<p> <a href='?p=contentedit&amp;id=$updatedId' class='aButton'>Editera mer</a>";
       }
    }
    else
    {
     //get values
     $post = $cont->getContent($id);
     $title = $post[0]->title;
     $slug = $post[0]->slug;
     $url = $post[0]->url;
     $data = $post[0]->data;
     $filter = $post[0]->filter;
     $published = $post[0]->published;

      // Sanitize content before using it.
      $title  = htmlentities($title, null, 'UTF-8');
      $slug   = htmlentities($slug, null, 'UTF-8');
      $url    = htmlentities($url, null, 'UTF-8');
      $data   = htmlentities($data, null, 'UTF-8');
      $filter = htmlentities($filter, null, 'UTF-8');
      $published = htmlentities($published, null, 'UTF-8');


     if($post[0]->type=="post")
       $options = '<option value="post" selected="selected">post</option><option value="page">page</option>';
     if($post[0]->type=="page")
       $options = '<option value="post">post</option><option value="page" selected="selected">page</option>';
     
     
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
    <h1 class="center">Redigera innehåll</h1>
    <form method=post $disabled>
         <p><label>Typ av innehåll:
            <select required="required" name='type' style='color: #555;' $disabled>
                {$options}
            </select>
         </label></p>
         <p><label>Titel:<br/><input type='text' required="required" name='title' value='{$title}' style='min-width:600px;' $disabled/></label></p>
        <input type='hidden' name='id' value='{$id}'/>
        <p><label>Slug:<br/><input type='text' name='slug' style='min-width:600px;' value='{$slug}' $disabled/></label></p>
        <p><label>Url:<br/><input type='text' name='url' style='min-width:600px;' value='{$url}' $disabled/></label></p>
        <p><label>Text:<br/><textarea name='data' style='min-width:598px;'>{$data}</textarea></label></p>
        <p><label>Filter:<br/><input type='text' name='filter' style='min-width:600px;' value='{$filter}'$disabled/></label></p>
        <p><label>Publiceringsdatum:<br/><input type='text' style='min-width:600px;' name='published' value='{$published}' $disabled/></label></p>
      <p><input type='submit' name='uppdate' value='Spara' $disabled/> <input type='reset' class='aButton' value='Återställ'/></p>
    </form>
      <p><a href='?p=uppdatecontent' class='aButton'>Avbryt</a></p>
  </div>
  $info
MYHTML;
    }
   }
}





