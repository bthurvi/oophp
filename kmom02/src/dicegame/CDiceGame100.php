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
  
  static public $enterPlayers = 1;
  static public $enterNames = 2;
  static public $gameRunning = 3;
  static public $gameStoped = 4;
  
  function __construct() 
  {
   $this->state= CDiceGame100::$enterPlayers;
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
  
    //if user has entered number of players
    if(isset($post['humans'])&& isset($post['ai']))
    {
      //only allow integer values
      $h = filter_input(INPUT_POST, 'humans', FILTER_SANITIZE_NUMBER_INT);
      $c = filter_input(INPUT_POST, 'ai', FILTER_SANITIZE_NUMBER_INT);
      
      
      //ensure that values is in correct range and that at one is human
      if($c>0 && $c<=4 && $h>=0 && $h<=4 && ($h>0))
      {
        //store number of humans and AI:s
        $this->humans=$h;
        $this->computerplayers=$c;
        
        //change state
        $this->changeGameState(CDiceGame100::$enterNames);
      }     
    }
    
    if(isset($post['playernames']))
    {
      //only allow strings
      $names = filter_input(INPUT_POST, 'playernames', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);

      //create player(s) from each namestring
      $this->createPlayers($names);
      
      //change state
      $this->changeGameState(CDiceGame100::$gameRunning);
    }
    
    //next input...
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
  private function setState($state){ $this->state = $state;}
}


