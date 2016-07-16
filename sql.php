<?php
//this is the class definition of sql class
function real_value($a)
{
	$result='';
	if (is_numeric($a))
		$result.=$a;
	else $result.='\''.$a.'\'';
	return $result;
}


class SQL
{
	private var $case=array();
	private var $values=array();
	private var $col=array();
	private var $query_num=0;
	private var $col_num=0;
	private var $flag=array();
	public var $table='';
	public var $type='';

	public function add($a,$b)//a is case,b is value
	{
		$case[$query_num]=$a;
		$value[$query_num]=$b;
		$query_num++;
		return $query_num;
	}

	//public function pop($num);//num is pop subscript

	public function add_col($a)
	{
		$col[$col_num]=$a;
		$col_num++;
		return $col_num;
	}

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

	public function get_flag()
	{
		return $flag;
	}

	public function generate()
	{
		if ($col_num==0)//origin query head
		{
			$flag['all']=true;
			if ($type=='s')
				$sql='SELECT * FROM '.$table;
		}
		//select where logic
		if ($query_num==0) return $sql;
		$sql.=' WHERE ';
		for ($i=0;$i<$query_num-1;$i++)
			$sql.=$case[$i].'='.real_values($values[$i]).' AND ';
		$sql.=$case[$query_num-1].'='.real_values($values[$query_num-1]).';';
		return $sql;
	}
}

?>