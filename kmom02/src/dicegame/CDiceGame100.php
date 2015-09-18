<?php


/**
 * Description of CDiceGame100
 *
 * @author urbvik
 */
class CDiceGame100 
{
  private $players = null;
  private $humans =0;
  private $computerplayers =0;
  private $state = null;
  private $messages = null;
  private $activePlayer=-1;
  
  private $dice = null;
  
  static public $enterPlayers = 1;
  static public $enterNames = 2;
  static public $gameRunning = 3;
  static public $haveWinner = 4;
  
  function __construct() 
  {
   $this->state= CDiceGame100::$enterPlayers;
   $this->dice=new C6Dice();
  }
  
  public function runGame($post)
  {
    $this->processInput($post);
    
    switch ($this->state) 
    {
      case CDiceGame100::$enterPlayers:
        echo CDiceGameMenus::chosePlayersMenu();
        break;
      case CDiceGame100::$enterNames:
        echo CDiceGameMenus::enterNamesForHumansMenu($this->humans);
        break;  
      case CDiceGame100::$gameRunning:
        echo CDiceGameMenus::gameBoard($this);
        break;  
      case CDiceGame100::$haveWinner:
        echo CDiceGameMenus::gameBoard($this,true);
        break;  
    }
  }
  
  private function doWeHaveAWinner()
  {
    $stop = count($this->players);
    for($i=0; $i<$stop; $i++) 
    {
       if($this->players[$i]->getScore()>=100)
       {
         //log that we have a winner
         $this->messages[] = "<b>{$this->players[$this->activePlayer]->getName()}</b> har vunnit. Grattis!<br/>"; 
         $this->changeGameState(CDiceGame100::$haveWinner);
         
         return true;
       }  
    }
    return false;
  }
  
  
  private function processInput($post)
  {
      var_dump($post);
      
    //if user has entered number of players
    if(isset($post['humans'])&& isset($post['ai']))
    {
      //only allow integer values
      $h = filter_input(INPUT_POST, 'humans', FILTER_SANITIZE_NUMBER_INT);
      $c = filter_input(INPUT_POST, 'ai', FILTER_SANITIZE_NUMBER_INT);
      
      
      //ensure that values is in correct range and that at one is human
      if($c>=0 && $c<=4 && $h>0 && $h<=5)
      {
        //store number of humans and AI:s
        $this->humans=$h;
        $this->computerplayers=$c;
        
        //change state
        $this->changeGameState(CDiceGame100::$enterNames);
      }     
    }
    
    
    if(isset($post['playernames']) && count($this->players)==0 )
    {
      //only allow strings
      $names = filter_input(INPUT_POST, 'playernames', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);

      //create player(s) from each namestring
      $this->createPlayers($names);
      
      //set first player as active
      $this->nextPlayer();
      
      //change state
      $this->changeGameState(CDiceGame100::$gameRunning);
    }
    
    if( isset($_POST["roll"]) && $_POST["roll"]=="Rulla tärningen")
      $this->runTurn();
    
    
    if( isset($_POST["save"]) && $_POST["save"]=="Stanna och spara")
      $this->saveTurn();
    
    //next button - for AI
    if(isset($_POST['next_turn_for_AI-player']))
    {
      if($this->getActivePlayer()->doLogic())
        $this->runTurn();
      else
        $this->saveTurn();
    }
 
    

  }
  
  private function saveTurn()
  {
    //get points
    $p=$this->dice->getSum();
    
    //add round to score
    $this->players[$this->activePlayer]->addToScore($p);
    
    //generate message
    $this->messages[]= "<b>{$this->getActivePlayerName()}</b> sparade <b>$p</b> poäng."
            . " Hen har nu totalt <b>{$this->players[$this->activePlayer]->getScore()}</b> poäng.";
            
    //if it is a AI-player - reset the decision logic before next turn
      if($this->getActivePlayer()->getType()=="AI")
      {
        $this->getActivePlayer()->resetLogic();
      }
    
    if(!$this->doWeHaveAWinner())
    {
      //reset dice (to zero points)
      $this->dice->resetSum();

      //next players turn
      $this->nextPlayer();
    }
  }
    
    
  private function runTurn()
  {
    $res = $this->dice->roll();
    
    $this->messages[]= "<b>{$this->getActivePlayerName()}</b> rullade tärningen och fick en <b>$res</b>a."
            . " Hen har nu <b>{$this->dice->getSum()}</b> poäng i omgången.";
            
    if($res==1)
    {
      $this->messages[]= "Eftersom <b>{$this->getActivePlayerName()}</b> fick en <b>$res</b>a "
            . " så blir det nu nästa spelares tur.";
      
      //if it is a AI-player - reset the decision logic before next turn
      if($this->getActivePlayer()->getType()=="AI")
      {
        $this->getActivePlayer()->resetLogic();
      }
      
      $this->nextPlayer();
    }
  }
  
  private function nextPlayer()
  {
    //set next player as active
    $this->activePlayer++;
    
     if($this->activePlayer>($this->computerplayers+$this->humans-1))
      $this->activePlayer=0;
    
    //log who is active
    $this->messages[] = "<b>{$this->players[$this->activePlayer]->getName()}</b>s tur.<br/>"; 
  }
  
  private function createPlayers($names)
  {
    var_dump($names);
    
      //create human players
      foreach ($names as $name) 
      {
        $this->players[] = new CPlayer($name,"spelare");
      }
      
      //create computer players
      for($i=1; $i<=$this->computerplayers; $i++)
      { 
        $this->players[] = new C3Player("Dator $i","AI"); 
      }
      
      //shuffle the players array
      shuffle($this->players);
  }
  
  private function changeGameState($state){ $this->state = $state;}
  public function getState(){ return $this->state;}
  public function getPlayers(){ return $this->players;}
  public function getActivePlayer(){ return $this->players[$this->activePlayer];}
  public function getActivePlayerName(){ return $this->players[$this->activePlayer]->getName();}
  public function getActivePlayerIndex(){ return $this->activePlayer;}
  public function getMessages(){ return $this->messages;}
  private function setState($state){ $this->state = $state;}
}


