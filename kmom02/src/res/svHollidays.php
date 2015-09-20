<?php

class holiDay {
  var $date, $desc, $flag;
  function holiDay($mon,$day,$year,$desc,$flag = false) {
    $this->desc = $desc;
    $this->flag = $flag;
    $this->date = mktime(12,0,0,$mon,$day,$year);
  }
  function is_holiday() {
    return true;
  }
  function flag() {
    return $this->flag;
  }
  function startFont() {
    return "<font color=\"red\">";
  }
  function endFont() {
    return "</font>";
  }
  
  public function getDate()
  {
    return $this->date;
  }
  
  public function getDesc()
  {
    return $this->desc;
  }

  function mkrow($flagday,$lang = 'sv') {
    if ($this->date >= 0)
      $ds = strftime("%e %B %Y (%A)",$this->date);
    else
      $ds = "<font color=\"blue\">".($lang == 'sv'?'[felaktigt datum]':'[bad date]')."</font>";
    return "<tr><td
class=\"nobg\">".$this->startFont().$this->desc[$lang].$this->endFont().
      "</td><td
class=\"nobg\">".$ds."</td>".($flagday ? "<td>".($this->flag() ? "<img
src=\"fl_sm_SWE.gif\" border=0
alt=\"Flaggdag\">" : "&nbsp;")."</td>" : "")."</tr>";
  }
  function compare($a,$b) {
    if ($a->date < $b->date)
      return -1;
    if ($a->date == $b->date)
      return 0; //strcmp($a->desc, $b->desc);
    return 1;
  }
}

class flagDay extends holiDay {
  function flag() {
    return true;
  }
  function is_holiday() {
    return false;
  }
  function startFont() {
    return "";
  }
  function endFont() {
    return "";
  }
}

function HDcompare($a,$b) {
    if ($a->date < $b->date)
      return -1;
    if ($a->date == $b->date)
      return 0; //strcmp($a->desc, $b->desc);
    return 1;
}
class marchDay extends holiDay{
  function marchDay($mon,$day,$year,$desc,$flag = false) {
    if ($day <= 31) {        // mars
      $mon = 3; $day = $day;
    } elseif ($day <= 31+30) {
      $mon = 4; $day = $day-31; // april
    } elseif ($day <= 31+30+31) {
      $mon = 5; $day = $day - (31+30); // maj
    } elseif ($day <= 31+30+31+30) {
      $mon = 6; $day = $day - (31+30+31); // juni
    } else {
      $mon = 3; $day = $day;    // hmm...
    }
    $p = get_parent_class($this);
    parent::$p($mon,$day,$year,$desc,$flag);
  }
}

function easterDay($y) {
  // Se http://aa.usno.navy.mil/faq/docs/easter.html
  $c = floor($y / 100);
  $n = $y - 19 * floor( $y / 19 );
  $k = floor(( $c - 17 ) / 25);
  $i = $c - floor($c / 4) - floor(( $c - $k ) / 3) + 19 * $n + 15;
  $i = $i - 30 * floor( $i / 30 );
  $i = $i - floor( $i / 28 ) * ( 1 - floor( $i / 28 ) * floor( 29 / ( $i + 1 ) )
                * floor( ( 21 - $n ) / 11 ) );
  $j = $y + floor($y / 4) + $i + 2 - $c + floor($c / 4);
  $j = $j - 7 * floor( $j / 7 );
  $l = $i - $j;
  $m = 3 + floor(( $l + 40 ) / 44); // month
  $d = $l + 28 - 31 * floor( $m / 4 ); // day

  return ($m == 3 ? $d : $d+31);
}


function getHolidays($year,$flagdays = false) {
  // Se http://www.jit.se/lagbok/989253t.html och http://www.jit.se/lagbok/982270t.html
// http://www.riksdagen.se/debatt/bet_yttr/dok.asp?dok_id=GS01KU6
  $easter = easterDay($year);
  // midsommardagen den lördag som infaller under tiden den 20--26 juni
  $ms = getdate(mktime(0,0,0,6,20,$year));
  $msd = 20 + (6-$ms['wday']);
  // alla helgons dag den lördag som infaller under tiden den 31
  // oktober--den 6 november
  $ah = getdate(mktime(0,0,0,10,31,$year));
  $ahd = 6-$ah['wday'];

  $hdays = array(new holiDay(1,1,$year,array('sv'=>"Nyårsdagen",
                         'en'=>'New Year Day'),true),
         new holiDay(1,6,$year,array('sv'=>"Trettondagen",
                         'en'=>'Epiphany')),
         new holiDay(5,1,$year,array('sv'=>"Första maj",
                         'en'=>'May Day'),true),
         new marchDay(3,$easter-2,$year,array('sv'=>"Långfredagen",
                              'en'=>'Good Friday')),
         new marchDay(3,$easter,$year,array('sv'=>"Påskdagen",
                            'en'=>'Easter Day'),true),
         new marchDay(3,$easter+1,$year,array('sv'=>"Annandag påsk",
                              'en'=>'Easter Monday')),
         new marchDay(3,$easter+5*7+4,$year,array('sv'=>"Kristi himmelsfärdsdag",
                              'en'=>'Ascension Day')),
         new marchDay(3,$easter+7*7,$year,array('sv'=>"Pingstdagen",
                            'en'=>'Pentecost Day'),
                  true),
         new holiDay(6,$msd,$year,array('sv'=>"Midsommardagen",
                        'en'=>'Midsummer Day'),true),
         ($ahd == 0 ?
          new holiDay(10,31,$year,array('sv'=>"Alla helgons dag",'en'=>"All Saint's Day")) :
          new holiDay(11,$ahd,$year,array('sv'=>"Alla helgons dag",'en'=>"All Saints' Day"))),
         new holiDay(12,25,$year,array('sv'=>"Juldagen",'en'=>'Christmas Day'),true),
         new holiDay(12,26,$year,array('sv'=>"Annandag jul",'en'=>'Boxing Day')));
  if ($year < 2005)
    $hdays[] = new marchDay(3,$easter+7*7+1,$year,array('sv'=>"Annandag pingst",
                            'en'=>'Whitmonday'));
  else
    $hdays[] = new holiDay(6,6,$year,array('sv'=>"Sveriges nationaldag och svenska flaggans dag",
                       'en'=>"Swedish National Day and the Swedish Flag's Day"),
               true);

  if ($flagdays) {
    $fdays = array(new flagDay(1,28,$year,array('sv'=>"Konungens namnsdag",
                        'en'=>"The King's Name Day")),
           new flagDay(3,12,$year,array('sv'=>"Kronprinsessans namnsdag",
                        'en'=>"The Crown Princess' Name Day")),
           new flagDay(4,30,$year,array('sv'=>"Konungens födelsedag",
                        'en'=>"The King's Birthday")),
           new flagDay(7,14,$year,array('sv'=>"Kronprinsessans födelsedag",
                        'en'=>"The Crown Princess' Birthday")),
           new flagDay(8,8,$year,array('sv'=>"Drottningens namnsdag",
                           'en'=>"The Queen's Name Day")),
           new flagDay(10,24,$year,array('sv'=>"FN-dagen",
                         'en'=>"UN Day")),
           new flagDay(11,6,$year,array('sv'=>"Gustav Adolfsdagen",
                        'en'=>"The Gustaf Adolf Day")),
           new flagDay(12,10,$year,array('sv'=>"Nobeldagen",
                         'en'=>'Nobel Day')),
           new flagDay(12,23,$year,array('sv'=>"Drottningens födelsedag",
                         'en'=>"The Queen's Birthday")));
    if ($year < 2005)
      $hdays[] = new flagDay(6,6,$year,array('sv'=>"Sveriges nationaldag och svenska flaggans dag",
                         'en'=>"Swedish National Day and the Swedish Flag's Day"));
    if ($year == 2010)
      $fdays[] = new flagDay(9,19,$year,array('sv'=>'Valdagen',
                          'en'=>'Election day'));
    $hdays = array_merge($hdays,$fdays);
  }
  usort($hdays,"HDcompare");
  return $hdays;
}

function show_holidays($year,$fromyear,$toyear,$flagdays = false, $lang = 'sv') {
  if ($fromyear != 0 and $toyear != 0) {
    $hdays = array();
    for ($yr = $fromyear; $yr <= $toyear; $yr++) {
      $hd = getHolidays($yr, $flagdays);
      $hdays = array_merge($hdays, $hd);
    }
  } else
    $hdays = getHolidays($year,$flagdays); // Hämta helgdagarna
  $rows = array();
  $hasbad = false;
  foreach ($hdays as $hd) {
    $rows[] = $hd->mkrow($flagdays,$lang);
    if ($hd->date <= 0) {
      $hasbad = true;
      break;
    }
  }
  if ($hasbad) {
    $last = getdate((1<<30)+(1<<29)+((1<<29)-1)); // 2^31-1
    $lyear = $last['year']-1;
    if ($lang == 'sv')
      return '<p style="color: blue">Kanske har du angivit ett för sent
eller för tidigt årtal för detta datorsystem? Prova mellan
'.date("Y",0).' och '.$lyear.'.</p>';
    else
      return '<p style="color: blue">Perhaps you have a too late or too early year for this computer system?  Try one between '.date("Y",0).' and '.$lyear.'.</p>';
  } else {
    return '<table border="1" class="nobg">'
      ."<tr><th class=\"nobg\">".($lang == 'sv' ? ($flagdays ? "Dag":"Helgdag") : ($flagdays ? 'Day' : 'Holiday'))."</th><th
class=\"nobg\">".($lang == 'sv' ? "Datum" : 'Date')."</th>".($flagdays ? ($lang == 'sv' ? "<th>Flaggdag</th>" : '<th>Flag day</th>'):"")."</tr>\n"
      .implode("\n",$rows)
      ."\n</table>\n";
  }
}


