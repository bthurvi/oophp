<?php

class CswMonths
{
	private static $months = array("Januari","Februari","Mars","April","Maj","Juni","Juli",
	           "Augusti","September","Oktober","November","December");
	
	public static function mon($nr)
	{
    
		if($nr>0 && $nr<13) 
			return self::$months[--$nr]; 	
	}
}

