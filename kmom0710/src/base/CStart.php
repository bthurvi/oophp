<?php



/**
 * Description of CStart
 *
 * @author urbvik
 */
class CStart 
{
  private $dbh = null;
  private $textfilter = null;
  private $latest3movies=null;
  private $genres=null;
  private $popular=null;
  private $lastRent=null;
  private $blogs=null;
  
  public function __construct($dbSettings) 
  { 
    $this->dbh = new CDatabase($dbSettings);
    $this->textfilter = new CTextFilter();
    $this->genres = CMovieSearch::getGenres($this->dbh,"movies");
    $this->latest3movies = $this->get3latestMovies();
    $this->popular = $this->getMostPopularMovie();
    $this->lastRent = $this->getLastRentMovie();
    $this->blogs = $this->get3blogs();
  }
  
  public function getHtml(){
  
   $movieImg = array();
   foreach ($this->latest3movies as $mov) {
     $movieImg[]= substr($mov->bild, strpos($mov->bild, '/') + 1);
   }
   $movieImg[]= substr($this->popular[0]->bild, strpos($this->popular[0]->bild, '/') + 1);
   $movieImg[]= substr($this->lastRent[0]->bild, strpos($this->lastRent[0]->bild, '/') + 1);
   
   $display = null;
   foreach ($this->blogs as $post)
   {
     $title  = ucfirst(htmlentities($post->title, null, 'UTF-8'));
     
     $data   = $this->textfilter->doFilter(htmlentities($post->data, null, 'UTF-8'), $post->filter);
     $result = preg_split('/(?<=[.?!])\s+/', $data, -1, PREG_SPLIT_NO_EMPTY);
        
        if(array_key_exists(0,$result))
        {
          $result = preg_split('/<br[^>]*>/i', $result[0]);
          $result = $result[0];
        }
        
       if(empty($result))
         $result = "Text saknas.";
       
       $result .= " <a href='?p=blogg&amp;slug={$post->slug}'>Läs mer »</a>";
     
     
     $display .= "<div class='blogpost'>\n"
                  . "<h2><a href='?p=blogg&amp;slug={$post->slug}'>$title</a></h2>"
                   . "<p>$result</p>"
                 . "</div>";
   }
   
  
    return <<< EOD
                <div class="categories">
                  <div class="heading">Filmkategorier:</div>
                  {$this->genres}
                </div>
                <div class="start">
                    <div>
                        <div class="cols2" style='float:left;'>
                          <div class="heading">Mest populära film:</div>
                          <a href="?p=movie&amp;id={$this->popular[0]->id}">
                          <img src='pages/img.php?src={$movieImg[3]}&amp;width=400&amp;height=150&amp;crop-to-fit' alt='en bild'/><br/>
                          {$this->popular[0]->titel}</a>
                        </div>
                        <div class="cols2">
                          <div class="heading">Senast hyrda film:</div>
                          <a href="?p=movie&amp;id={$this->lastRent[0]->id}">
                          <img src='pages/img.php?src={$movieImg[4]}&amp;width=400&amp;height=150&amp;crop-to-fit' alt='en bild'/><br/>
                          {$this->lastRent[0]->titel}</a>
                        </div>
                    </div>
                    <div class="newFilms">
                        <div class="heading">Nyaste filmerna:</div>
                       <div class="cols3">
                          <a href="?p=movie&amp;id={$this->latest3movies[0]->id}">
                          <img src='pages/img.php?src={$movieImg[0]}&amp;width=350&amp;height=150&amp;crop-to-fit' alt='en bild'/><br/>
                          {$this->latest3movies[0]->titel}</a>
                       </div>
                       <div class="cols3">
                          <a href="?p=movie&amp;id={$this->latest3movies[1]->id}">
                          <img src='pages/img.php?src={$movieImg[1]}&amp;width=350&amp;height=150&amp;crop-to-fit' alt='en bild'/><br/>
                          {$this->latest3movies[1]->titel}</a>
                       </div>
                       <div class="cols3">
                          <a href="?p=movie&amp;id={$this->latest3movies[2]->id}">
                          <img src='pages/img.php?src={$movieImg[2]}&amp;width=350&amp;height=150&amp;crop-to-fit' alt='en bild'/><br/>
                          {$this->latest3movies[2]->titel}</a>
                       </div>
                    </div>
                    <div class="latestBlogs">
                      <div class="heading">Senaste blogginlägg:</div>
                      {$display}
                    </div>
                </div>
EOD;
  }
  
  private function get3latestMovies()
  {
     $sql = "SELECT M.id as id, M.title as titel, I.image as bild
      FROM oophp0710_movie AS M
        INNER JOIN oophp0710_movie2image AS M2I
          ON M2I.movie_id = M.id
        INNER JOIN oophp0710_images AS I
          ON M2I.image_id = I.id
        GROUP BY titel
        ORDER BY creationdate
        LIMIT 3";
     
    $res = $this->dbh->ExecuteSelectQueryAndFetchAll($sql);
    
    return $res;
  }
  
  private function getMostPopularMovie(){
    
     $sql = "SELECT M.id as id, M.title as titel, I.image as bild
      FROM oophp0710_movie AS M
        INNER JOIN oophp0710_movie2image AS M2I
          ON M2I.movie_id = M.id
        INNER JOIN oophp0710_images AS I
          ON M2I.image_id = I.id
        WHERE M.id=7
        LIMIT 1";
     
     $res = $this->dbh->ExecuteSelectQueryAndFetchAll($sql);
    
    return $res;
  }
  private function getLastRentMovie(){
    
    $sql = "SELECT M.id as id, M.title as titel, I.image as bild
      FROM oophp0710_movie AS M
        INNER JOIN oophp0710_movie2image AS M2I
          ON M2I.movie_id = M.id
        INNER JOIN oophp0710_images AS I
          ON M2I.image_id = I.id
        WHERE M.id=4
        LIMIT 1";
     
     $res = $this->dbh->ExecuteSelectQueryAndFetchAll($sql);
    
    return $res;
    
  }
  
  private function get3blogs(){
    
    $sql = "SELECT * FROM oophp0710_content WHERE type = 'post' AND published <= NOW() AND deleted IS NULL ORDER BY updated DESC LIMIT 3;";
    
    
    $res = $this->dbh->ExecuteSelectQueryAndFetchAll($sql);
    
    return $res;
  }
}
