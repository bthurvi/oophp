
<h1 class="center">Återställ tabellerna CContent och Cuser</h1>
<p>Genom att klicka på knappen nedan återställer du ovanstående tabeller (i filmdatabasen) till sitt ursprung:</p>

<form method="post">
    <input type="submit" value="Återställ">
    <input type='hidden' name="restore" /> 
</form>


<?php
if(isset($_POST['restore'])) // reset via post disabled for now: || isset($_GET['restore'])) 
{
  $cont = new CContent($urbax['database']);
  echo $cont->reset();
}


