<?php

/**
 * Description of CDiceGameMenus
 * 
 * This class contains user-menus for a dice game
 * 
 * @author urbvik 2015-09-15
 */
class CDiceGameMenus 
{
              
public static function chosePlayersMenu()
{
  return <<<EOT
<div>
  <form method="post">
    <h3>Tävla mot fyra datorspelare (AI) om att först nå 100 poäng. Vinn en videofilm!</h3>
    <span class="lablewidth100">Människor:</span>
    <label><input type="radio" name="humans" value="1" checked>1 </label>  
    <br/>
    <span class="lablewidth100">Datorspelare (AI):</span>
    <label><input type="radio" name="ai" value="4" checked>4 </label>
    <p>
    <input type="hidden" name="cont" value="fortsätta spela">
    <input type="submit" value="Nästa &#10095;" />
    </p>
  </form>
</div>
EOT;
}


  
public static function enterNamesForHumansMenu($nrOfHumans)
{
   $html = <<<EOT
<div>
  <form method="post">
    <h3>Ange e-postadress dit eventuell vinst skall skickas</h3>
      <label>
EOT;
   
   for($i=0; $i<$nrOfHumans; $i++)
   {
    $html .= '<span class="lablewidth100">E-post :</span>';
    $html .= '<input type="email" name="playernames[]" autofocus required>';
    //$html .= '<input type="text" name="playernames[]" autofocus required>';
    $html .= "<br/>";
   }
   
   $html .= <<<EOS
</label> 
    <input type="hidden" name="cont" value="fortsätta spela">
    <p>
    <input type="submit" value="Nästa &#10095;" />
    </p>
  </form>
</div>
EOS;
   
   return $html;
  
}

public static function gameBoard($game, $winner=false, $dbsettings)
{
  $html = <<<EOA
<h1>Tärningsspelet 100</h1>
<section>
    <h2>Poängställning</h2>
EOA;
  
  $theWinner = null;
  foreach ($game->getPlayers() as $key => $player)
  {
    if($player->getScore()>=100)
      $theWinner = $player;
    
    $html .= "<div>";
    $html .= "<span id='indicator' class='";
    
    if($key==$game->getActivePlayerIndex())
      $html .=  "arrow-left";
    
    $html .= "'></span>";
    $html .= "<label><span> {$player->getName()}</span> ({$player->getType()}):</label>";
    $html .= "<progress value='{$player->getScore()}' max='100'></progress> {$player->getScore()}";
    $html .= "</div>";
  }
   
  $html .= <<<EOA
</section>

<h2>Beskrivning</h2>
<div id="gameinfo">
EOA;
  
  $messages = array_reverse($game->getMessages());
  foreach($messages as $msg) 
  {
    $html .= $msg ."<br/>" ;
  }
 
            
$html .= <<<EOA
</div>
<h2>Kontrollpanel</h2>
<form id="controls" method="post">
<input type="hidden" name="cont" value="fortsätta spela">
EOA;
if($winner)
{
  if($theWinner->getType()=='spelare')
  {
    //save in database
    $dbh = new CDatabase($dbsettings);

    $sql = "INSERT INTO oophp0710_vinners(mail,points) VALUES(?,?)";
    $params = array($theWinner->getName(),$theWinner->getScore());

    $dbh->ExecuteQuery($sql, $params);
    
    $html .= "Ditt vinst är nu sparad i databasen. Innom kort kommer du att kontaktas via e-post.";
  }
$html .= <<<EOA
    <div>Vill du <input type="submit" value="starta ett nytt spel" name="restart">?</div>
EOA;
} 
else if($game->getActivePlayer()->getType()=="spelare")
{
$html .= <<<EOA
    <div><input type="submit" value="Rulla tärningen" name="roll"/> 
        <input type="submit" value="Stanna och spara" name="save"/></div>
EOA;
}
else if($game->getActivePlayer()->getType()=="AI" )
{
$html .= <<<EOA
 <div><input type="submit" value="Nästa &#10095;" name="next_turn_for_AI-player"/> </div>
EOA;
}

        
$html .= "</form>";

  
  return $html;
}

public static function restartMenu()
{
return <<<EOB
<form method="post">
    <h1>Det finns en påbörjad spelomgång i minnet</h1>
    Vill du:
    <input type="submit" value="fortsätta spela" name="cont"> eller
    <input type="submit" value="starta ett nytt spel" name="restart">?
 </form>
EOB;
}

}
