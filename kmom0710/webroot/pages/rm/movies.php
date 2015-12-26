<h1 style='margin: 0; margin-bottom:10px;'>Filmsökning</h1>

<?php



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($urbax['database']);


// Get parameters 
$title    = isset($_GET['title']) ? $_GET['title'] : null;
$genre    = isset($_GET['genre']) ? $_GET['genre'] : null;
$hits     = isset($_GET['hits'])  ? $_GET['hits']  : 5;
$page     = isset($_GET['page'])  ? $_GET['page']  : 1;
$year1    = isset($_GET['year1']) && !empty($_GET['year1']) ? $_GET['year1'] : null;
$year2    = isset($_GET['year2']) && !empty($_GET['year2']) ? $_GET['year2'] : null;
$orderby  = isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'title';
$order    = isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';





// Check that incoming parameters are valid
is_numeric($hits) or die('Check: Hits must be numeric.');
is_numeric($page) or die('Check: Page must be numeric.');
is_numeric($year1) || !isset($year1)  or die('Check: Year must be numeric or not set.');
is_numeric($year2) || !isset($year2)  or die('Check: Year must be numeric or not set.');


// Show search form
echo CMovieSearch::getSearchForm('movies',$page,$hits,$title,$year1,$year2,$db);


// Run SQL query
$res =  CMovieSearch::ExecuteSelectQueryAndFetchAll($page, $hits, $title, $year1, $year2, $genre, $order, $orderby, $db);




// Display resulting table
if(count($res['resultset'])>0)
  echo CHTMLTable::generateHTMLtableResult($res['resultset'],'table',$hits,$page,$res['maxresults']);
else
  echo "Inga filmer matchar angivna sökkriterier";