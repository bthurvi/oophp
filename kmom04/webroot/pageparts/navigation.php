<?php


function setActive($items) {
  $ref = isset($_GET['p']) && isset($items[$_GET['p']]) ? $_GET['p'] : null;
  
  if($ref) 
  {
    $items[$ref]['class'] .= 'activeNav'; 
  }
  return $items;
}

/*$menu = array('callback' => 'setActive',
              'items' => array( 'about'  => array('text'=>'Om mig',  'url'=>'?p=about', 'class'=>null),
                                'dice'  => array('text'=>'Tärningar',  'url'=>'?p=dice', 'class'=>null),                          
                                'slideshow'  => array('text'=>'Bildspel',  'url'=>'?p=slideshow', 'class'=>null),
                                'dicegame' => array('text'=>'Tärning100', 'url'=>'?p=dicegame','class'=>null),
                                'calendar' => array('text'=>'Kalender', 'url'=>'?p=calendar','class'=>null),
                                'movie' => array('text'=>'Filmdatabas', 'url'=>'?p=movie','class'=>null),
                                'code'  => array('text'=>'Källkod',  'url'=>'?p=code', 'class'=>null),
                                'desc' => array('text'=>'Redovisningar', 'url'=>'?p=desc','class'=>null),                                                        
  ),
);

//menu to display
$nav = CNavigation::GenerateMenu("navmenu",$menu);
$urbax['nav'] = $nav;
*/

//menu to display
$menu = array(new CMenuItem('Tarningar','?p=dice'), 
              array(new CMenuItem('Kasta en tärning','?p=dice'),new CMenuItem('Tärningsspelet 100','?p=dicegame')),
              new CMenuItem('Bildspel','?p=slideshow'),
              new CMenuItem('Kalender','?p=calendar'),
              new CMenuItem('Filmdatabas','?p=movie'),
              //new CMenuItem('Djur','?'),
              //array(new CMenuItem('Ankor','?p=anka'),array(new CMenuItem('Anderssons tama anka','?p=andank'),new CMenuItem('Vild anka','?p=vildank')), 
              // new CMenuItem('Babian','?p=babian'),new CMenuItem('Citronfjäril','?p=fjaril')),
              new CMenuItem('Information','?p=desc'),
              array(new CMenuItem('Redovisningar','?p=desc'),new CMenuItem('Visa källkod','?p=code'),new CMenuItem('Utveckling','?p'),array(new CMenuItem('Om mig','?p=about')))
            );


$htmlMenu = new CDynamicDropDownMenu($menu,"activeNav");
if(isset($_GET['p']))
	$htmlMenu->HilighALLtMenuItemsBasedOnGetParam('p');  
$urbax['nav'] =	 $htmlMenu->GetMenu();


//content to show
if(!isset($_GET['p']))
  header("location:?p=about");
else
{
  switch($_GET['p'])
  {
    case "about": 
      $file = "aboutme.php";
      $urbax['title'] = "Om mig";
      break;
    case "dice": 
      $file = "dice.php"; 
      $urbax['title'] = "Kasta tärning";
      break;
    case "dicegame": 
      $file = "dicegame.php"; 
      $urbax['title'] = "Tärningsspelet 100";
      $urbax['stylesheets'][]="css/dicegame.css";
      break;
    case "slideshow": 
      $file = "slideshow.php"; 
      $urbax['title'] = "Visa bildspel";
      break;
    case "movie": 
      $file = "movie.php"; 
      $urbax['title'] = "Filmdatabas";
      break;
    case "code": 
      $file = "showcode.php"; 
      $urbax['title'] = "Visa källkod";
      $urbax['stylesheets'][]="css/source.css";
      break;
    case "desc": 
      $file = "description.php";
      $urbax['title'] = "Redovisning";
      break;
    case "calendar": 
      $file = "manadens_babe.php";
      $urbax['title'] = "Kalender";
      $urbax['stylesheets'][]="css/calendar.css";
      break;
    default : header("location:?p=about");
  }
  $content = "pages/$file";
}


?>
