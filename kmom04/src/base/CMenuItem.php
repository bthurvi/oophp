<?php

class CMenuItem
{
   public $text;
   public $url;
   public $cssClass;

   public function __construct($text,$url)
   {
	  $this->text=$text;
	  $this->url=$url;
   }
}