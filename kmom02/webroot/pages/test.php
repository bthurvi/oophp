<?php

/*var_dump ($_SESSION);


if(isset($_POST['continue']) && $_POST['continue']=="continue" )
{ 
  var_dump ($_SESSION);
}
else if(isset($_POST['restart']) && $_POST['restart']=="restart")
{
  echo "Startar nytt spel.";
  $t = new CTest();
  $_SESSION['t']=$t;
}
else if(isset($_SESSION['t']) )
{
  echo "Det verkar finnas ett pågående spel:";
  echo "<form method='post'>";
  echo "<input type='submit' value='continue' name='continue'>";
  echo "<input type='submit' value='restart' name='restart' >";
  echo "<a href='destroySession.php'>Förstör sessionen</a>";
  echo "</form >";
}
else 
{
  echo "Inleder ett nytt spel.";
  $t = new CTest();

}*/




//restart game
if(isset($_POST['restart']) && $_POST['restart']=="starta ett nytt spel")
{
  unset($_SESSION['game']);
}


if(!isset($_SESSION['game'])) 
{
  echo "<h1>Startar ny spelomgång</h1>";
   $_SESSION['game'] = new CDiceGame100();
   $theGame = $_SESSION['game'];
}
else if(isset($_SESSION['game']) && (isset($_POST['cont']) && $_POST['cont']=="fortsätta spela"))
{
  echo "Fortsätter spelomgång";
  $theGame = $_SESSION['game'];
}
else if(isset($_SESSION['game']) && (!isset($_POST['game-on'])))
{
  echo "Frågar om forsätta eller starta ny omgång";
  echo CDiceGameMenus::restartMenu();
}

//if we got a instance - run the game
if(isset($theGame))
  $theGame->runGame($_POST);


//dump below used for debugging
echo "<div style='border:1px solid black; background: #eee; padding: 10px; margin-top:100px;'>";
var_dump($_SESSION);
echo "</div>";









