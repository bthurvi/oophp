<?php

class CDice{
	
    //properties     
    public $results = [];

	//rollDice method
	public function RollDice($times)
	{
		for ($i=0; $i<$times; $i++) 
			$this->results[] = rand(1,6); 
	}

	//show results in array
	public function Dump()
	{
		return var_dump($this->results);
	}

	public function GetRolls()
	{
		return implode(", ", $this->results);
	}


	//calculate sum of rolls
	public function GetSum()
	{
		return array_sum($this->results);
	}

	public function GetAverage()
	{
		return $this->GetSum()/count($this->results);
	}

}