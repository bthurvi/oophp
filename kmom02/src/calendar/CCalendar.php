<?php

include '../src/res/svHollidays.php';

class CCalendar
{
  private $month;
  private $year;
  private $monthNr;
  private $holidays;
  private $holidaysDesc;
  
  function __construct($ynr,$nr) 
  {
    if($nr>0 && $nr<13) 
    {
      $this->monthNr=$nr;
      $this->month=CswMonths::mon($nr);
    }
    if($ynr>10 && $ynr<=30)
    {
      $this->year= $ynr;
      
      //calculate hollidays for current year
      $h = getHolidays("20".$ynr);
      foreach ($h as $hday)
      {
        $this->holidays[] = date("y-m-d",$hday->getDate());
        $this->holidaysDesc[] = $hday->getDesc()['sv'];
      }
     
    }
  
   }
   
   public function showHollidays()
   {
     
     $html="<div style='padding:1em'>"
           . "<h3 style='margin-top:0'>20" .$this->year. " har följande extra söndagar</h3>";
     
     foreach ($this->holidays as $i=>$hday)
       $html .= "20" .$hday ." " .$this->holidaysDesc[$i]. "<br/>";
     
     return $html."<p style='margin-bottom:0;'>Credit to <em>Björn Viktor</em> (Bjorn@Victor.se) för kod som att räknar fram dagarna "
             . "ovan. <a target='_blank' href='http://victor.se/bjorn/holidays.php'>Källa.</a> </p></div>";
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
     

    <section>	
     {$this->calendarTable()}
     {$this->showHollidays()}
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
     
     $html = "<table>";
     $html .= "<tr class='grey loline'><td class='vecka'>Vecka</td><td>Måndag</td><td>Tisdag</td>"
             . "<td>Onsdag</td><td>Torsdag</td><td>Fredag</td><td>Lördag</td>"
             . "<td>Söndag</td></tr>";
     $html .= "<td class='vecka grey'>".date_format($date,"W")."</td>";
     
     $diff = new DateInterval( "P1D" );
     for($i=1;$i<=42;$i++)
     {
       //format dates according to how important day is
       if(date_format($date,"m")==$this->monthNr && in_array(date_format($date,"y-m-d"),$this->holidays))
         $html .= "<td class='day sunday'>".date_format($date,"j")."</td>";
       else if(date_format($date,"m")==$this->monthNr && date_format($date,"D")=="Sun")
         $html .= "<td class='day sunday'>".date_format($date,"j")."</td>";
       else if(date_format($date,"m")==$this->monthNr)
        $html .= "<td class='day'>".date_format($date,"j")."</td>";
       else
        $html .= "<td class='notThisMonth'>".date_format($date,"j")."</td>";
        
        
        $date->add($diff);
        
        if($i<42 && $i%7==0)
          $html .=  "</tr><tr><td class='vecka grey'>".date_format($date,"W")."</td>";
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

