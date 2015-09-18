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
    //this AI keeps allways tries to reach at least 15 points (or wins).   
    if($this->dice->getSum()<=15 && ($this->dice->getSum()+$this->getScore())<100)
      return true;
    else
      return false;

      
  }
  
  public function resetLogic()
  {
    //do nothing... 
  }  
}


