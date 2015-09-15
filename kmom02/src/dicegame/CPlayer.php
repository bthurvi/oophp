<?php

/**
 * Description of CPlayer
 *
 * @author urbvik
 */

class CPlayer {
  
   private $rolls=[];
   private $score;
   private $name;
   private $type;
   
   function __construct($name, $type) 
   {
     $this->name=$name;
     $this->type=$type;
   }

   
   public function rollDice($echo=true)
   {
      //roll dice
      $res=C6Dice::roll();
      
      //save all rolls as history
      $this->rolls[]= $res;
      
      //count score
      if($res===0)
        {$this->score=0;}
      else
        {$this->score+=$res;}
        
      if($echo)
      {
        echo "<p><strong>$this->name</strong> kastar tärningen och får {$res}a, "
        . "$this->sex har nu ". $this->getScore() . " poäng.";
      }
   }
   
   public function getScore(){ return $this->score;}
   public function getName(){ return $this->name;}
   public function getType(){ return $this->type;}
}
