<?php


function setActive($items) {
  $ref = isset($_GET['p']) && isset($items[$_GET['p']]) ? $_GET['p'] : null;
  
  if($ref) 
  {
    $items[$ref]['class'] .= 'activeNav'; 
  }
  return $items;
}


//menu to display
$menu = array(new CMenuItem('Tarningar','?p=dice'), 
              array(new CMenuItem('Kasta en tärning','?p=dice'),new CMenuItem('Tärningsspelet 100','?p=dicegame')),
              new CMenuItem('Bildspel','?p=slideshow'),
              new CMenuItem('Kalender','?p=calendar'),
              new CMenuItem('Filmdatabas','?p=movie'),
              array(new CMenuItem('Visa alla','?p=movie'),new CMenuItem('Återställ','?p=moviereset'), new CMenuItem('Sök efter titel','?p=movietitlesearch'),
                   new CMenuItem('Sök efter år','?p=movieyearsearch')),
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
      $urbax['title'] = "Visa alla i filmdatabasen";
      break;
    case "moviereset": 
      $file = "moviereset.php"; 
      $urbax['title'] = "Återställ filmdatabasen";
      break;
    case "movietitlesearch": 
      $file = "movie_title_search.php"; 
      $urbax['title'] = "Sök film per titel";
      break;
    case "movieyearsearch": 
      $file = "movie_year_search.php"; 
      $urbax['title'] = "Sök film per år";
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
