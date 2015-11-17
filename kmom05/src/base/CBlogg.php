<?php

class CBlogg
{
  private $html;
  private $dbh;

  public function __construct($options, $slug, $slugSql)
  {
    $this->dbh = new CDatabase($options);
    $textfilter = new CTextFilter();
    
    // Get content
    $sql = "SELECT * FROM Content WHERE type = 'post' AND $slugSql AND published <= NOW() AND deleted IS NULL ORDER BY updated DESC;";
    
    $res = $this->dbh->ExecuteSelectQueryAndFetchAll($sql, array($slug));
    
   

    // show  ALL blogg post
   if($slugSql==1) 
   {
      $display = "<h1>Visar alla bloggposter:</h1>\n";
      foreach ($res as $post) 
      {
        
         // Sanitize content before using it.
        $title  = ucfirst(htmlentities($post->title, null, 'UTF-8'));
        $data   = $textfilter->doFilter(htmlentities($post->data, null, 'UTF-8'), $post->filter);
        $info = "<span class='info'>Av: {$this->getUser($post->author)}, $post->created</span>";
      
        $display .= "<div class='blogpost'>\n<h2><a href='?p=contentblogg&amp;slug={$post->slug}'>$title</a></h2>\n$info\n<p>$data</p></div>";
      }
   }
    else // show ONLY ONE post
   {
      $post = $res[0];
      
      // Sanitize content before using it.
      $title  = htmlentities($post->title, null, 'UTF-8');
      $data   = $textfilter->doFilter(htmlentities($post->data, null, 'UTF-8'), $post->filter);
      $info = "<span class='info'>Av: {$this->getUser($post->author)}, $post->created</span>";
      
      $display = "<div class='blogpost' style='min-height: 300px'>\n<h2><a href='?p=contentblogg&amp;slug={$post->slug}'>$title</a></h2>\n$info\n<p>$data</p></div><p><a href='?p=contentblogg' class='aButton'>Visa alla</a></p>";
    }
    
     $html = <<< PAGECONT
          <article>
             $display
          </article>
PAGECONT;
    
    $this->html = $html;

  }
  
  private function getUser($akronym)
  {
   
    $sqlUser = "SELECT * FROM user WHERE acronym=?";
    $param = array($akronym);
    $user = $this->dbh->ExecuteSelectQueryAndFetchAll($sqlUser, $param);
   
    if($user)
      return $user[0]->name;
    else
      return 'INGET NAMN HITTAT';
  }
  
  public function getPage()
  {
    return $this->html;
  }
      

}
