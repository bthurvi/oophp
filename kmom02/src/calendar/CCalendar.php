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
     {$this->calendarTable()}
    </section>
EOT;
   
     return $html;
   }
   
   private function calendarTable()
   {
     //första dagen i månaden
     $d="20".$this->year."-".$this->monthNr."-01";
     $date= new DateTime($d);
     //echo "<p>Första dagen i månaden är: ".date_format($date,"D d/m (Y)");
     
     //första dagen i kalender-tabellen
     $f= $this->dayOfWeek($this->year,$this->monthNr,false)-1;
     $diff = new DateInterval( "P".$f."D" ); 
     $date->sub($diff);
     //echo "<p>Startdatum för kalendertabellen är: ".date_format($date,"D d/m (Y)");
     
     $html = "<table border=1>";
     $html .= "<tr><td>Måndag</td><td>Tisdag</td><td>Onsdag</td><td>Torsdag</td>"
             . "<td>Fredag</td><td>Lördag</td><td>Söndag</td></tr>";
     $diff = new DateInterval( "P1D" );
     for($i=1;$i<=42;$i++)
     {
        $html .= "<td>".date_format($date,"d")."</td>";
        $date->add($diff);
        
        if($i<42 && $i%7==0)
          $html .=  "</tr><tr>";
     }
      $html .=  "</tr></table>";
      
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

