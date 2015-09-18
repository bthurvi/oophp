<?php


/**
 * Description of C3Player
 *
 * @author urbvik
 */

class C15PointPlayer extends CPlayer 
{
  private $dice;
  
  function __construct($name,$type,$dice) 
  {
     $this->dice=$dice;
     parent::__construct($name, $type);
  }
  
  public function doLogic()
  {
    //this AI keeps allways tries to reach at least 15 points...   
    if($this->dice->getSum()<=15)
      return true;
    else
      return false;

      
  }
  
  public function resetLogic()
  {
    echo "<h2>Resetting the game logic</h2>";
    $this->nrOfRolls=0;
  }  
}


