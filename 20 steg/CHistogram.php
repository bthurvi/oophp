<?php

class CHistogram{

	private $histogram = [];

	public function GetHistogram($arr)
	{
		$this->histogram = array_count_values($arr);
		ksort($this->histogram);

		foreach ($this->histogram as $key => $value) 
		{
			$this->histogram[$key] = "";

			for ($i=0; $i < $value; $i++) 
				$this->histogram[$key] .= "*";

			$this->histogram[$key] .= " ($value)";
		}
		return $this->histogram;
	}
}