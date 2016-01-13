<div>
    <a class="bread" href="?p=start">Start >> </a>
    <a class="bread" href="?p=game"> tävling </a>
</div>
<?php

//restart game
if(isset($_POST['restart']) && $_POST['restart']=="starta ett nytt spel")
{
  unset($_SESSION['game']);
}

//new game, continue old, restart or run the game
if(!isset($_SESSION['game'])) 
{
  echo "<h1>Startar ny spelomgång</h1>";
   $_SESSION['game'] = new CDiceGame100();
   $theGame = $_SESSION['game'];
}
else if(isset($_SESSION['game']) && (isset($_POST['cont']) && $_POST['cont']=="fortsätta spela"))
{
  $theGame = $_SESSION['game'];
}
else if(isset($_SESSION['game']) && (!isset($_POST['game-on'])))
{
  echo CDiceGameMenus::restartMenu();
}

//if we got a instance - run the game
if(isset($theGame))
  $theGame->runGame($_POST,$urbax['database']);











