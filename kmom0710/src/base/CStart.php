<?php



/**
 * Description of CStart
 *
 * @author urbvik
 */
class CStart 
{
  private $dbh = null;
  private $latest3movies=null;
  private $genres=null;
  
  public function __construct($dbSettings) 
  { 
    $this->dbh = new CDatabase($dbSettings);
    $this->genres = CMovieSearch::getGenres($this->dbh,"movies");
    $this->latest3movies = $this->get3latestMovies();
  }
  
  public function getHtml(){
  
   $movieImg = array();
   foreach ($this->latest3movies as $mov) {
     $movieImg[]= substr($mov->bild, strpos($mov->bild, '/') + 1);
   }

   
  
    return <<< EOD
                <div class="categories">
                  <div class="heading">Filmkategorier:</div>
                  {$this->genres}
                </div>
                <div class="start">
                    <div>
                        <div class="cols2">
                          Mest populära film 
                        </div>
                        <div class="cols2">
                          Senast hyrda film
                        </div>
                    </div>
                    <div class="newFilms">
                        <div class="heading">Nyaste filmerna:</div>
                       <div class="cols3">
                          <img src='pages/img.php?src={$movieImg[0]}&amp;width=400&amp;height=250&amp;crop-to-fit' alt='en bild'/><br/>
                          {$this->latest3movies[0]->titel}
                       </div>
                       <div class="cols3">
                          <img src='pages/img.php?src={$movieImg[1]}&amp;width=400&amp;height=250&amp;crop-to-fit' alt='en bild'/><br/>
                          {$this->latest3movies[1]->titel}
                       </div>
                       <div class="cols3">
                          <img src='pages/img.php?src={$movieImg[2]}&amp;width=400&amp;height=250&amp;crop-to-fit' alt='en bild'/><br/>
                          {$this->latest3movies[2]->titel}
                       </div>
                    </div>
                    <div class="latestBlogs">
                      De tre senaste blogginläggen
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
}
