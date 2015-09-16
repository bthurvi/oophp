<?php

/**
 * Description of C6Dice
 * 
 * A simple class containing a function that simulates a six sided dice roll
 *
 * @author urbvik
 */
class C6Dice 
{
  private $history=[];
  private $sum;
  
  public function roll()
  {
    $r=rand(1,6);
    $this->calcSum($r);
    return $r; 
  }
  
  private function calcSum($r)
  {
     if($r!=1)
      $this->sum += $r;
    else
       $this->sum == 0;
  }
  
  
  public function getSum()
  {
    return $this->sum;
  }
}


  
