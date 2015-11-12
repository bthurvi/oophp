<?php
setlocale(LC_TIME,"sv","sv_SE");

  if(isset($_GET['y']) && isset($_GET['m']))
  {
    $m = filter_input(INPUT_GET,'m',FILTER_VALIDATE_INT);
    $y = filter_input(INPUT_GET,'y',FILTER_VALIDATE_INT);
    
    
    if($m>0 && $m<13 && $y>10 && $y<=30) 
    {
      $cal=new CCalendar($y,$m);
    }
    
  }
  else
  {
    
    $m=date('n');
    $y=date('y');
    $cal=new CCalendar($y,$m);
  }
  
  //echo "Aktuell månad är: $y - $m";
  echo $cal->show();
?>
















