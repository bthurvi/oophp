<?php

class CDynamicDropDownMenu
{
  private $menuArray;
  private $cssClass;
  private $needleIndex;
  private $allIndexesArray=null;

  public function __construct($MenuAsArrayOfCMenuItems=null,$activeMenuItemCssClass=null)
  {
	$this->menuArray = $MenuAsArrayOfCMenuItems;
    $this->cssClass = $activeMenuItemCssClass;
  }

  public function GetMenu($menu=null)
  {
	if(is_null($menu))
		$menu=$this->menuArray;

    $html = "\n<ul>"; 

  
    foreach ($menu as $item) 
    {
        if(is_array($item))
          $html .=  $this->GetMenu($item);
        else
        {
          if($item->cssClass)
            $html .= "<li class='$item->cssClass'><a href='$item->url'>{$item->text}</a>";
          else
            $html .= "<li><a href='$item->url'>{$item->text}</a>";
        }
    }

    $html .="</li>\n</ul>";    
    return  $html;
  }


  public function GenerateMenu($MenuAsArrayOfCMenuItems,$activeMenuItemCssClass)
  {
  	$this->cssClass = $activeMenuItemCssClass;
  	return $this->GetMenu($MenuAsArrayOfCMenuItems);
  }


  public function HilighALLtMenuItemsBasedOnGetParam($getParamName)
  {
    //if get-param p is set - hilight menuitems
    if(isset($_GET[$getParamName]))
    {
        //find menu index
        $this->menuIndex($this->menuArray,$_GET[$getParamName]);

    } 
  }

   private function menuIndex($arr,$needle,$index=null, $i=0)
   {
    	//store last elements key and add element to index array
    	$last = count($index);
    	$index[] = $i;
    	
    	//loop trough array
    	foreach ($arr as $key=>$item) 
    	{
    		//each lap store the key (needed for sub ements)
    		$index[$last]=$key;

    		//check if we have an array or not
    		if(is_array($item))
    		   $this->menuIndex($item,$needle,$index,$key);
    		else if($item->url=="?p=$needle")
    		{
          //save index
          $this->needleIndex = $index; 

          //find all indexes - parents included (and stores them in allIndexsArray)
          $this->findAllIndexes($this->needleIndex);

          //highlight all indexes
          foreach ($this->allIndexesArray as $index) 
            $this->highlightElement($index);

    		}			
    	}
   }

   private function findAllIndexes($needleIndex)
   {
      $len = count($needleIndex);

      //find all indexes - include parents
          for ($i=1; $i<=$len ; $i++) 
          {
            $curr = null;
            
            for ($j=0; $j<$i ; $j++) 
            { 
              if($j==($i-1) && $j!=($len-1))
                 $curr[] = $needleIndex[$j]-1;
               else
                 $curr[] = $needleIndex[$j];
            }

            $this->allIndexesArray[] = $curr;
          }
   }


  //debug function
   public function printAllIndexes()
   {
    foreach ($this->allIndexesArray as $key => $indexArray) 
    {
      echo "$key: ";

      foreach ($indexArray as $index)
        echo "[$index]";

      echo "<br>";
    }
   }


   private function highlightElement($indexArray,$menuArray=null,$nr=0)
   {
      //index to get
      $i=$indexArray[$nr];

      //if menu is null take menuArray
      if($menuArray==null)
        $menuArray = $this->menuArray; 
      
      //create itterator
      $iter = new RecursiveArrayIterator($menuArray);

      //move to current index
      $iter->seek($i);

      //move down until we have found the element - then set the css-class for that element
      if(is_array($iter->current()))
        $this->highlightElement($indexArray,$iter->getChildren(),($nr+1));
      else
        $iter->current()->cssClass = $this->cssClass;
      
  
   }





}