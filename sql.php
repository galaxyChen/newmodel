<?php
//this is the class definition of sql class
function real_value($a)
{
	$result='';
	if (is_numeric($a))
		$result.=$a;
	else $result.=$a.'123';
	return $result;
}


class SQL
{
	private $case=array();
	private $values=array();
	private $col=array();
	private $query_num=0;
	private $col_num=0;
	private $flag=array();
	public $table='';
	public $type='';

	public function add($a,$b)//a is case,b is value
	{
		$this->case[$this->query_num]=$a;
		$this->values[$this->query_num]=$b;
		$this->query_num++;
		return $this->query_num;
	}

	//public function pop($num);//num is pop subscript

	public function add_col($a)
	{
		$col[$this->col_num]=$a;
		$this->col_num++;
		return $this->col_num;
	}

	public function get_case()
	{
		return $this->case;
	}

	public function get_values()
	{
		return $this->values;
	}

	public function get_num()
	{
		return $this->query_num;
	}

	public function get_flag()
	{
		return $this->flag;
	}

	public function generate()
	{
		if ($this->col_num==0)//origin query head
		{
			$this->flag['all']=true;
			if ($this->type=='s')
				$sql='SELECT * FROM '.$this->table;
		}
		//select where logic
		if ($this->query_num==0) return $sql;
		$sql.=' WHERE ';
		for ($i=0;$i<$this->query_num-1;$i++)
			$sql.=$this->case[$i].'='.real_value($this->values[$i]).' AND ';
		$sql.=$this->case[$this->query_num-1].'=';
		$sql.=real_value($this->values[$this->query_num-1]).';';
		return $sql;
	}
}

?>