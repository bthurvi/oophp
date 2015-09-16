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
  static public $gameStoped = 4;
  
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
    }
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
    {
      echo "dags att rulla tärningen!";
      $this->runTurn();
    }
    //next input...
  }
  
  private function runTurn()
  {
    $res = $this->dice->roll();
    $this->messages[]= "<b>{$this->getActivePlayerName()}</b> rullade tärningen och fick en <b>$res</b>a.";
    $this->messages[]= "<b>{$this->getActivePlayerName()}</b> har nu <b>{$this->dice->getSum()}</b> poäng i omgången.";

  }
  
  private function nextPlayer()
  {
    //set next player as active
    $this->activePlayer++;
    
     if($this->activePlayer>($this->computerplayers+$this->humans))
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
        $this->players[] = new CPlayer("Dator $i","AI"); 
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


