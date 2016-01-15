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
  //$menu[] = new CMenuItem('Koppla bilder',"?p=imageselect&amp;path=movie");
}

/*$menu = array(new CMenuItem('Tärningar','?p=dice'), 
              array(new CMenuItem('Kasta en tärning','?p=dice'),new CMenuItem('Tärningsspelet 100','?p=dicegame')),
              new CMenuItem('Bildspel','?p=slideshow'),
              new CMenuItem('Kalender','?p=calendar'),
              new CMenuItem('Filmdatabas','?p=movie'),
              array( new CMenuItem('Guide -&gt;','?p=movie'),
              array(new CMenuItem('Visa alla','?p=movie'),new CMenuItem('Återställ','?p=moviereset'), new CMenuItem('Sök via titel','?p=movietitlesearch'),
                   new CMenuItem('Sök via år','?p=movieyearsearch'), new CMenuItem('Sök via genre','?p=moviegenresearch'),new CMenuItem('Sortera','?p=moviesort'),
                   new CMenuItem('Paginering','?p=paginate'),new CMenuItem('Logga in','?p=login'),new CMenuItem('Logga ut','?p=logout'),new CMenuItem('Uppdatera','?p=uppdate'),
                   new CMenuItem('Ny film','?p=newmovie'), new CMenuItem('Radera film','?p=deletemovie'),new CMenuItem('Sök alla','?p=moviesearchall')),
              new CMenuItem('CDatabase','?p=cdbovningar'),new CMenuItem('CMovieSearch','?p=generate'), 
              new CMenuItem('CUser -&gt;','?p=cstatus'), array( new CMenuItem('Status','?p=cstatus'), new CMenuItem('Logga in','?p=clogin'), new CMenuItem('Logga ut','?p=clogout') )  ),
              new CMenuItem('Lagra innehåll','?p=ctextfilter'));

    
$menu[] = addBloggsAndPagesToNavbar(); //add database content (pages/blogposts)  to navbar

$menu[] =     new CMenuItem('Galleri','?p=gallery');
$menu[] =     array(new CMenuItem('Bildgalleri','?p=gallery'));

$menu[] =     new CMenuItem('Information','?p=desc');
$menu[] =     array(new CMenuItem('Redovisningar','?p=desc'),new CMenuItem('Visa källkod','?p=code'),new CMenuItem('Utveckling -&gt;','?p'),array(new CMenuItem('Om mig','?p=about') ) );
            
*/

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
    /*case "about": 
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
      $file = "movie/movie.php"; 
      $urbax['title'] = "Visa alla i filmdatabasen";
      break;
    case "moviereset": 
      $file = "movie/moviereset.php"; 
      $urbax['title'] = "Återställ filmdatabasen";
      break;
    case "movietitlesearch": 
      $file = "movie/movie_title_search.php"; 
      $urbax['title'] = "Sök film per titel";
      break;
    case "movieyearsearch": 
      $file = "movie/movie_year_search.php"; 
      $urbax['title'] = "Sök film per år";
      break;
    case "moviegenresearch": 
      $file = "movie/movie_genre_search.php"; 
      $urbax['title'] = "Sök film per genre";
      break;
    case "moviesort": 
      $file = "movie/moviesort.php"; 
      $urbax['title'] = "Sortera filmer";
      break;
    case "moviegenresearch": 
      $file = "movie/movie_genre_search.php"; 
      $urbax['title'] = "Sök film per genre";
      break;
    case "moviesearchall": 
      $file = "movie/movie_search_all.php"; 
      $urbax['title'] = "Sök film";
      break;
    case "paginate": 
      $file = "movie/moviepaginate.php"; 
      $urbax['title'] = "Paginering av poster";
      break;
    case "login": 
      $file = "movie/login.php"; 
      $urbax['title'] = "Logga in &amp; ut";
      break;
    case "logout": 
      $file = "movie/logout.php"; 
      $urbax['title'] = "Logga in &amp; ut";
      break;
    case "uppdate": 
      $file = "movie/movie_uppdate.php"; 
      $urbax['title'] = "Uppdatera filminformation";
      break;
    case "newmovie": 
      $file = "movie/movie_new.php"; 
      $urbax['title'] = "Skapa ny film";
      break;
    case "deletemovie": 
      $file = "movie/movie_delete.php"; 
      $urbax['title'] = "Radera film";
      break;
    case "cdbovningar": 
      $file = "test.php"; 
      $urbax['title'] = "Övnignar med CDatabase";
      break;
    case "generate": 
      $file = "generateHTMLtable.php"; 
      $urbax['title'] = "Paginerad och sökbar OOP tabell";
      break;
    case "cstatus": 
      $file = "status.php"; 
      $urbax['title'] = "Visa användarstatus";
      break;
    case "clogin": 
      $file = "login.php"; 
      $urbax['title'] = "Logga in";
      break;
    case "clogout": 
      $file = "logout.php"; 
      $urbax['title'] = "Logga ut";
      break;
    case "ctextfilter": 
      $file = "content/testfilter.php"; 
      $urbax['title'] = "Övning med CTextFilter";
      break;
    case "contentreset": 
      $file = "content/content_reset.php"; 
      $urbax['title'] = "Återställ tabeller";
      break;
    case "contentpage": 
      $file = "content/page.php"; 
      $urbax['title'] = "Visa page";
      break;
    case "contentblogg": 
      $file = "content/blogg.php"; 
      $urbax['title'] = "Visa blogg";
       $urbax['stylesheets'][]="css/blogg.css";
      break;
    case "code": 
      $file = "showcode.php"; 
      $urbax['title'] = "Visa källkod";
      $urbax['stylesheets'][]="css/source.css";
      break;
   
    case "gallery": 
      $file = "gallery.php";
      $urbax['title'] = "Bildgalleri";
      $urbax['stylesheets'][]="css/gallery.css";
      break;*/
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
