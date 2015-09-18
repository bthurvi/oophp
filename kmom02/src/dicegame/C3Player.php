<?php


/**
 * Description of C3Player
 *
 * @author urbvik
 */
class C3Player extends CPlayer 
{
  private $nrOfRolls=0;
  
  public function continueRoll()
  {
    $this->nrOfRolls++;
    
    echo "<p>" . $this->name . " har rolls: " . $this->$nrOfRolls;
    
    //this AI allways tries to roll three times and then stops
    if($this->$nrOfRolls<=3)
      return true;
    else
    {
      $this->$nrOfRolls=0;
      return false;
    }
      
  }
}
