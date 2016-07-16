<?php
//this is the class definition of sql class
class SQL
{
	private $case=array();
	private $values=array();
	private $query_num=0;
	private $flag=array();
	public $table='';
	public $type='';

	public function add($a,$b)//a is case,b is value
	{
		$case[$query_num]=$a;
		$value[$query_num]=$b;
		$query_num++;
		return $query_num;
	}

	//public function pop($num);//num is pop subscript

	public function get_case()
	{
		return $case;
	}

	public function get_values()
	{
		return $values;
	}

	public function get_num()
	{
		return $query_num;
	}

	public function generate()
	{
		if ($query_num==0)
		{
			$flag['all']=true;
			if ($type=='s')
				$sql='SELECT * FROM '.$table;
			return $sql;
		}
	}
}

?>