<h1 class="center">Tärningsspelet 100</h1>



<?php

//run game
$game = new CDiceGame100();

//procees inputs in game logic
if(isset($_POST) && $_POST!=NULL)
  $game->input($_POST);
else 
  $game->runGame();

echo gameBoard();




/*
 * Below is presentation functions (views) - not part of game logic
 */

function chosePlayersMenu()
{
  return <<<EOT
<div>
  <form method="post">
    <h3>Välj antal spelare</h3>
    <span class="lablewidth100">Människor:</span>
    <label><input type="radio" name="humans" value="1" checked>1 </label> 
    <label><input type="radio" name="humans" value="2">2 </label> 
    <label><input type="radio" name="humans" value="3">3 </label> 
    <label><input type="radio" name="humans" value="4">4 </label> 
    <br/>
    <span class="lablewidth100">Datorspelare (AI):</span>
    <label><input type="radio" name="ai" value="1">1 </label> 
    <label><input type="radio" name="ai" value="2" checked>2 </label> 
    <label><input type="radio" name="ai" value="3">3 </label> 
    <label><input type="radio" name="ai" value="4">4 </label>
    <p>
    <input type="submit" value="Nästa &#10095;" />
    </p>
  </form>
</div>
EOT;
}


  
function enterNamesForHumansMenu($nrOfHumans)
{
   $html = <<<EOT
<div>
  <form method="post">
    <h3>Ange namn</h3>
    <label>
EOT;
   
   for($i=0; $i<$nrOfHumans; $i++)
   {
    $html .= '<span class="lablewidth100">Spelare '.($i+1).':</span>';
    $html .= '<input type="text" name="playername" autofocus required>';
    $html .= "<br/>";
   }
   
   $html .= <<<EOS
    </label> 
    <p>
    <input type="submit" value="Nästa &#10095;" />
    </p>
  </form>
</div>
EOS;
   
   return $html;
  
}

function gameBoard()
{
  return <<<SSS
  <section>
    <h2>Poängställning</h2>
    <div><label><span>Urban</span> (spelare):</label><progress value="42" max="100"></progress> 42</div>
    <div><label><span>Anna</span> (spelare):</label><progress value="22" max="100"></progress> 22</div>
    <div><label><span>Urban</span> (dator):</label><progress value="50" max="100"></progress> 50</div>
    <div><label><span>Urban</span> (dator):</label><progress value="89" max="100"></progress> 89</div>
    <div><label><span>Urban</span> (människa):</label><progress value="42" max="100"></progress> 42</div>
    <div><label><span>Anna</span> (människa):</label><progress value="22" max="100"></progress> 22</div>
    <div><label><span>Urban</span> (dator):</label><progress value="50" max="100"></progress> 50</div>
    <div><label><span>Urban</span> (dator):</label><progress value="89" max="100"></progress> 89</div>
</section>

<h2>Beskrivning</h2>
<div id="gameinfo">
    <strong>Kalles</strong> tur.<br>
    <strong>Urban</strong> väljer att avsluta sin omgång.<br>
    <strong>Urban</strong> fick en 3:a hen har nu 42 poäng.<br>
    <strong>Urban</strong> väljer att kasta tärningen.<br>
    <strong>Urbans</strong> tur.<br>
</div>

<h2>Kontrollpanel</h2>
<form id="controls">
    <div><input type="submit" value="Kasta tärningen en gång till" /> 
        <input type="submit" value="Lägg ner tärningen och spara" /></div>
    <div><input type="submit" value="Nästa &#10095;" /> </div>
</form>
SSS;
}
  

?>



        



