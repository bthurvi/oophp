<?php

class CPage
{
  private $html;

  public function __construct($options, $url, $urlSql)
  {
    
    
    $dbh = new CDatabase($options);
    $textfilter = new CTextFilter();
    
    // Get content
    $sql = "SELECT * FROM Content WHERE type = 'page' AND $urlSql AND published <= NOW();";
    
    $res = $dbh->ExecuteSelectQueryAndFetchAll($sql, array($url));

    
    if($urlSql==1) //visa alla poster
    {
      $data='';
      foreach ($res as $row) 
      {
        $title="Alla sidor:";
      
        // Sanitize content before using it.
        $data .= "<a href='?p=contentpage&amp;url={$row->url}'>". htmlentities($row->title, null, 'UTF-8') . "</a><br/>";
   
      }
    
    $html = <<< PAGECONT
          <article>
          <h2>$title</h2> 
          <p>$data</p>
          </article>
PAGECONT;
    
    $this->html = $html;
      
    }
    else //visa en post
    {
      $data = $res[0];
      
      // Sanitize content before using it.
    $title  = htmlentities($data->title, null, 'UTF-8');
    $data   = $textfilter->doFilter(htmlentities($data->data, null, 'UTF-8'), $data->filter);
    
    $data .= "<p>&nbsp;</p><hr style='margin-bottom:10px;'><p><a href='?p=contentpage' class='aButton'>Visa alla</a></p>";
    
    $html = <<< PAGECONT
          <article>
          <h2>$title</h2> 
          $data
          </article>
PAGECONT;
    
    $this->html = $html;
      
    }
    
    

  }
  
  public function getPage()
  {
    return $this->html;
  }
      

}
