<?php




function setActive($items) {
  $ref = isset($_GET['p']) && isset($items[$_GET['p']]) ? $_GET['p'] : null;
  
  if($ref) 
  {
    $items[$ref]['class'] .= 'activeNav'; 
  }
  return $items;
}


function addBloggsAndPagesToNavbar()
{
  //connnect to database
  global $urbax;
  $db = new CDatabase($urbax['database']);

  //defalut navigaion items
  $arr = array(new CMenuItem('CTextFilter','?p=ctextfilter'),new CMenuItem('CContent ->','?p=contentreset'),array(new CMenuItem('Återställ','?p=contentreset'),
                new CMenuItem('Nytt innehåll','?p=contentadd'),new CMenuItem('Editera innehåll','?p=contentedit'),new CMenuItem('Radera','?p=contentdelete')),
                new CMenuItem('CPage','?p=contentpage'),new CMenuItem('CBlogg','?p=contentblogg'));
  
  
  //fetch pages
  $pages = $db->ExecuteSelectQueryAndFetchAll("SELECT title, url FROM Content WHERE type='page' AND deleted IS NULL");
  
  //add pages to navigation
  if(count($pages)>0)
  {
     $pagesNavItem = new CMenuItem('Webbsidor ->','?p=contentpage');
     $subPages = null;
     
     foreach ($pages as $navItem) 
     {
       //get text
       $text = ucfirst($navItem->title);
       
       //and shorten it if needed...
       if (strlen($text) > 20)
         $text = substr($text, 0, 17) . '...';
       
       //get url
       $url = $navItem->url;
       
       //add to array
       $subPages[] = new CMenuItem($text, '?p=contentpage&amp;url='.$url);
     }
     
     //add 'headline'
     $arr[] = $pagesNavItem;
     
     //add subpages
     $arr[] = $subPages;
   
  }
  
  //fetch blogposts
  $posts = $db->ExecuteSelectQueryAndFetchAll("SELECT title, slug FROM Content WHERE type='post' AND deleted IS NULL");
  
  //add pages to navigation
  if(count($posts)>0)
  {
     $postsNavItem = new CMenuItem('Bloggposter ->','?p=contentblogg');
     $subPages = null;
     
     foreach ($posts as $navItem) 
     {
       //get text
       $text = ucfirst($navItem->title);
       
       //and shorten it if needed...
       if (strlen($text) > 20)
         $text = substr($text, 0, 17) . '...';
       
       //get slug
       $slug = $navItem->slug;
       
       //add to array
       $subPages[] = new CMenuItem($text, '?p=contentblogg&amp;slug='.$slug);
     }
     
     //add 'headline'
     $arr[] = $postsNavItem;
     
     //add subpages
     $arr[] = $subPages;
   
  }
 
  

  return $arr;
}


//menu to display

$menu = array(new CMenuItem('Start','?p=start'),
              new CMenuItem('Filmer','?p=movies'),
              new CMenuItem('Nyheter','?p=blogg'),
              new CMenuItem('Kalender','?p=calendar'),
              new CMenuItem('Tävling','?p=game'),
              new CMenuItem('Om RM','?p=about'),
              new CMenuItem('Profil','?p=profile'),
              new CMenuItem('Visa källkod','?p=code'),
              new CMenuItem('Redovisningar','?p=report'),
    );

if($user->IsAuthenticated())
{
  $menu[] = new CMenuItem('Administration','');
  $menu[] = array(
            new CMenuItem('Ny film','?p=newmovie'),
            new CMenuItem('Uppdatera film','?p=updatemovie'),
            new CMenuItem('Radera film','?p=deletemovie'),
            new CMenuItem('Nytt innehåll','?p=addcontent'),
            new CMenuItem('Uppdatera innehåll','?p=uppdatecontent'),
            new CMenuItem('Radera innehåll','?p=deletecontent')
      );
 
}



$htmlMenu = new CDynamicDropDownMenu($menu,"activeNav");

if(isset($_GET['p']))
	$htmlMenu->HilighALLtMenuItemsBasedOnGetParam('p');

$urbax['nav'] =	 $htmlMenu->GetMenu();


//content to show
if(!isset($_GET['p']))
  header("location:?p=start");
else
{
  switch($_GET['p'])
  {
    case "report": 
      $file = "description.php";
      $urbax['title'] = "Redovisning";
      break;
    case "code": 
      $file = "showcode.php"; 
      $urbax['title'] = "Visa källkod";
      $urbax['stylesheets'][]="css/source.css";
      break;
    case "game": 
      $file = "rm/dicegame.php"; 
      $urbax['title'] = "Spel";
      $urbax['stylesheets'][]="css/dicegame.css";
      break;
    case "calendar": 
      $file = "rm/kalender.php";
      $urbax['title'] = "Kalender";
      $urbax['stylesheets'][]="css/calendar.css";
      break;
    case "start": 
      $file = "rm/start.php";
      $urbax['title'] = "Startsida";
      $urbax['stylesheets'][]="css/rmstart.css";
      break;
    case "about": 
      $file = "rm/about.php";
      $urbax['title'] = "Om RM";
      break;
    case "profile": 
      $file = "rm/profile.php";
      $urbax['title'] = "Profil";
      break;
    case "movies":
      $file = "rm/movies.php"; 
      $urbax['title'] = "Filmer";
      break;
    case "blogg": 
      $file = "rm/blogg.php"; 
      $urbax['title'] = "Nyheter";
      break;
    case "movie":
      $file = "rm/movie.php"; 
      $urbax['title'] = "Visar en film";
      break;
    case "updatemovie":
      $file = "rm/updatemovie.php"; 
      $urbax['title'] = "Uppdatera filminformation";
      break;
    case "deletemovie":
      $file = "rm/deletemovie.php"; 
      $urbax['title'] = "Radera film";
      break;
    case "newmovie":
      $file = "rm/newmovie.php"; 
      $urbax['title'] = "Skapa film";
      break;
     case "uppdatecontent": 
      $file = "rm/uppdatecontent.php"; 
      $urbax['title'] = "Redigera innehåll";
      break;
    case "addcontent": 
      $file = "rm/addcontent.php"; 
      $urbax['title'] = "Lägg till innehåll";
      break;
    case "deletecontent": 
      $file = "rm/deletecontent.php"; 
      $urbax['title'] = "Radera innehåll";
      break;
    case "imageselect":
      $file = "rm/selectimage.php"; 
      $urbax['title'] = "Koppla bilder till film";
       $urbax['stylesheets'][]="css/rmselectimage.css";
       $urbax['stylesheets'][]="css/sweetalert.css";
       $urbax['javascript_include'][] = 'js/sweetalert.min.js';
      break;
    default : 
      header("location:?p=about");
  }
  
  $urbax['content'] = "pages/$file";
}


?>
