<?php

class CBlogg
{
  private $html;
  private $dbh;

  public function __construct($options, $slug, $slugSql,$cat)
  {
    $this->dbh = new CDatabase($options);
    $textfilter = new CTextFilter();
    
    $whereCat=null;
    if($cat)
      $whereCat = "AND category= '$cat'";
    
    // Get content
    $sql = "SELECT * FROM oophp0710_content WHERE type = 'post' $whereCat AND $slugSql AND published <= NOW() AND deleted IS NULL ORDER BY updated DESC;";
    
  
    
    $res = $this->dbh->ExecuteSelectQueryAndFetchAll($sql, array($slug));
    
   

    // show  ALL blogg post
   if($slugSql==1) 
   {
      $display = "<div>
    <a class='bread' href='?p=start'>Start >> </a>
    <a class='bread' href='?p=movies'>nyheter </a>
    <p></p>
</div>\n";
      $display .= "<h1>Nyheter/blogginlägg:</h1>\n";
      foreach ($res as $post) 
      {
        
         // Sanitize content before using it.
        $title  = ucfirst(htmlentities($post->title, null, 'UTF-8'));
        $data   = $textfilter->doFilter(htmlentities($post->data, null, 'UTF-8'), $post->filter);
        $result = preg_split('/(?<=[.?!])\s+/', $data, -1, PREG_SPLIT_NO_EMPTY);
        
        if(array_key_exists(0,$result))
        {
          $result = preg_split('/<br[^>]*>/i', $result[0]);
          $result = $result[0];
        }
        
       if(empty($result))
         $result = "Text saknas.";
       
       $result .= " <a href='?p=blogg&amp;slug={$post->slug}'>Läs mer »</a>";
        
        //var_dump($result);
        $info = "<span class='info'>Av: {$this->getUser($post->author)}, $post->created</span>";
        
        $cate=null;
        if(!empty($post->category))
        {
        $cate = "<a style='display: inline-block;float: right;padding: 5px; font-size:10px;' href='?p=blogg&amp;cat={$post->category}'>Kategori: $post->category</a>";}
      
        $display .= "<div class='blogpost'>\n<h2><a href='?p=blogg&amp;slug={$post->slug}'>$title</a>"
                    .$cate. "</h2>\n$info\n<p>$result</p></div>";
      }
      
       if($cat)
         $display .= "<p><a href='?p=blogg' class='aButton'>Visa alla</a></p>";
   }
    else // show ONLY ONE post
   {
      $post = $res[0];
      
      // Sanitize content before using it.
      $title  = htmlentities($post->title, null, 'UTF-8');
      $data   = $textfilter->doFilter(htmlentities($post->data, null, 'UTF-8'), $post->filter);
      $info = "<span class='info'>Av: {$this->getUser($post->author)}, $post->created</span>";
      
      $display = "<div>
    <a class='bread' href='?p=start'>Start >> </a>
    <a class='bread' href='?p=blogg'>nyheter >> </a>
    <a class='bread' href='?p=blogg&amp;slug={$_GET['slug']}'> " . lcfirst($title)."</a><p></p></div>\n";
      
      
      $display .= "<div class='blogpost' style='min-height: 300px'>\n<h2><a href='?p=contentblogg&amp;slug={$post->slug}'>$title</a></h2>\n$info\n<p>$data</p></div><p><a href='?p=blogg' class='aButton'>Visa alla</a></p>";
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
   
    $sqlUser = "SELECT * FROM oophp0710_user WHERE acronym=?";
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
