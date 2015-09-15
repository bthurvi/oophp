<?php


function setActive($items) {
  $ref = isset($_GET['p']) && isset($items[$_GET['p']]) ? $_GET['p'] : null;
  
  if($ref) 
  {
    $items[$ref]['class'] .= 'activeNav'; 
  }
  return $items;
}

$menu = array('callback' => 'setActive',
              'items' => array( 'about'  => array('text'=>'Om mig',  'url'=>'?p=about', 'class'=>null),
                                'dice'  => array('text'=>'Tärningar',  'url'=>'?p=dice', 'class'=>null),
                                'dicegame' => array('text'=>'Tärningsspelet 100', 'url'=>'?p=dicegame','class'=>null),
                                'slideshow'  => array('text'=>'Bildspel',  'url'=>'?p=slideshow', 'class'=>null),
                                'code'  => array('text'=>'Källkod',  'url'=>'?p=code', 'class'=>null),
                                'desc' => array('text'=>'Redovisningar', 'url'=>'?p=desc','class'=>null),
                                'test' => array('text'=>'Test', 'url'=>'?p=test','class'=>null),
                                'dest' => array('text'=>'avsluta session', 'url'=>'?p=dest','class'=>null),
  ),
);

//menu to display
$nav = cNavigation::GenerateMenu("navmenu",$menu);
$urbax['nav'] = $nav;

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
    case "code": 
      $file = "showcode.php"; 
      $urbax['title'] = "Visa källkod";
      $urbax['stylesheets'][]="css/source.css";
      break;
    case "desc": 
      $file = "description.php";
      $urbax['title'] = "Redovisning";
      break;
    case "test": 
      $file = "test.php";
      $urbax['stylesheets'][]="css/dicegame.css";
      $urbax['title'] = "Test";
      break;
    case "dest": 
      $file = "destroysession.php";
      $urbax['title'] = "Förstör sessionen";
      break;
    default : header("location:?p=about");
  }
  $content = "pages/$file";
}


?>
