<?php

/**
 * Description of CPlayer
 *
 * @author urbvik
 */

class CPlayer {
  
   private $rolls=[];
   private $score;
   protected $name;
   private $type;
   
   function __construct($name, $type) 
   {
     $this->name=$name;
     $this->type=$type;
   }

   
   public function getScore(){ return $this->score;}
   public function addToScore($points){ $this->score += $points; return $this->score;}
   public function resetScore(){ $this->score=0; return $this->score;}
   public function getName(){ return $this->name;}
   public function getType(){ return $this->type;}
}
