<?php

class CCalendar
{
  private $month;
  private $year;
  private $monthNr;
  
  function __construct($ynr,$nr) 
  {
    if($nr>0 && $nr<13) 
    {
      $this->monthNr=$nr;
      $this->month=CswMonths::mon($nr);
    }
    if($ynr>10 && $ynr<=30)
      $this->year= $ynr;
   
   }
   
   public function show()
   {
     //nuvarande månad
     $d="20".$this->year."-".$this->monthNr."-01";
     $date=date_create($d);
     
     //nästa månad
     $nextdate=date_add($date, date_interval_create_from_date_string('1 month'));
     $next="y=".date_format($nextdate,"y")."&amp;m=".date_format($nextdate,"n");
     
     //föregående månad
     $prevdate=date_sub($date, date_interval_create_from_date_string('2 months'));
     $prev="y=".date_format($prevdate,"y")."&amp;m=".date_format($prevdate,"n");
     
     
     
     $html=<<<EOT
     <header>
     <a class="left navsquare" href="?p=calendar&amp;{$prev}">&#10094;</a>
     <a class="right navsquare" href="?p=calendar&amp;{$next}">&#10095;</a>
     <h2 class="strokeme">{$this->month} 20{$this->year}</h2>
     <img class="header" src="img/calendar/{$this->getMonthImage()}" 
     alt="image of the month"></header>
     <header>

    <section>	
     {$this->month} 20{$this->year} startar med dag nr {$this->dayOfWeek($this->year,$this->monthNr,false)} i veckan.
     <p>
     {$this->month} 20{$this->year} har {$this->daysInMonth($this->year,$this->monthNr)} dagar i månaden.
    </section>
EOT;
   
     return $html;
   }
   
   public function dayOfWeek($yearNr,$monthNr,$echo=false)
   {
     $timestamp=mktime(0, 0, 0, $monthNr,1,$yearNr);
     $dayNr = date('N',$timestamp);
     
     $html= "<p>Datumet " . date('Y-m-d',$timestamp) . " är en ";
     $html.= date('D',$timestamp) . " (dvs dag nummer $dayNr i veckan)."; 
     
     if($echo)
       echo $html;
     
     return $dayNr; 
   }
   
   public function daysInMonth($yearNr,$monthNr)
   {
     $number = cal_days_in_month(CAL_GREGORIAN, $monthNr, $yearNr);
     return $number;
   }
           
   public function getMonth(){return $this->month;}
   public function getMonthNr(){return $this->monthNr;}
   public function getMonthImage(){return strtolower(substr($this->month,0,3)) . ".jpg";}
   

  
}

