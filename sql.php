<?php
//this is the class definition of sql class
function real_value($a)
{
	$result='';
	if (gettype($a)!='string')
		$result.=$a;
	else $result.='\''.$a.'\'';
	return $result;
}


class SQL
{
	private $case=array();
	private $values=array();
	private $col=array();
	private $col_values=array();
	private $query_num=0;
	private $col_num=0;
	private $flag=array();
	private $orKey=array();
	private $orValue=array();
	private $orNum=0;
	public $table='';
	public $type='';
	private $or_where=false;
	private $not_col=0;
	private $not_key=array();
	private $not_value=array();

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
		$this->col[$this->col_num]=$a;
		$this->col_num++;
		return $this->col_num;
	}

	public function add_update_col($a,$b)
	{
		$this->col[$this->col_num]=$a;
		$this->col_values[$this->col_num]=$b;
		$this->col_num++;
		return $this->col_num;
	}

	public function add_or($a,$b){
		$this->orKey[$this->orNum]=$a;
		$this->orValue[$a]=$b;
		$this->orNum++;
		$this->or_where=true;
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

	private function where_generate($sql)
	{
		if ($this->or_where){
			$sql.='(';
			for ($i=0;$i<$this->orNum;$i++){
				$value=$this->orValue[$this->orKey[$i]];
				$n=count($value);
				
				for ($j=0;$j<$n-1;$j++){
					$sql.=$this->orKey[$i].' = ? OR ';
				}
				$sql.=$this->orKey[$i].' = ? )';
				if ($i<$this->orNum-1)
					$sql.=' AND (';
			}
			return $sql;
		}
		for ($i=0;$i<$this->query_num-1;$i++)
			$sql.=$this->case[$i].'= ? AND ';
		$sql.=$this->case[$this->query_num-1].'= ?';
		if ($this->not_col>0) {
			$sql.=" AND ";
			for ($i=0;$i<$this->not_col-1;$i++)
				$sql.=$this->not_key[$i]." <> ? AND ";
			$sql.=$this->not_key[$i]." <> ?";
		}
		return $sql;
	}

	public function add_not($key,$value){
		$this->not_key[$this->not_col]=$key;
		$this->not_value[$this->not_col]=$value;
		$this->not_col++;
	}

	public function generate()
	{
		// if ($this->or_where){
		// 	return where_generate();
		// }
		$sql='';
		if ($this->col_num==0)//origin query head
		{
			if ($this->type=='s')//tyep is select
				$sql='SELECT * FROM '.$this->table;

			if ($this->type=='i')
				$sql='INSERT INTO '.$this->table;
		}
		else //add col query
		{
			if ($this->type=='s')
				{
					$sql='SELECT ';
					for ($i=0;$i<$this->col_num-1;$i++)
						$sql.=$this->col[$i].', ';
					$sql.=$this->col[$this->col_num-1];
					$sql.=' FROM '.$this->table;
				}

		}
		//select where logic
		if ($this->type=='s')
		{
			if ($this->query_num==0&&!$this->or_where) 
			{
				$this->flag['all']=true;
				return $sql;
			}
			$sql.=' WHERE ';
			$sql=$this->where_generate($sql);
			//$sql.=real_value($this->values[$this->query_num-1]).';';
			return $sql;
		}

		if ($this->type=='i')//insert logic
		{
			$sql.=' (';
			for ($i=0;$i<$this->query_num-1;$i++)
				$sql.=$this->case[$i].', ';
			$sql.=$this->case[$this->query_num-1].') ';
			$sql.='VALUES (';
			for ($i=0;$i<$this->query_num-1;$i++)
				$sql.='?, ';
			$sql.='?);';
			return $sql;
		}
		//update logic
		if ($this->type=='u')
		{
			$sql='UPDATE '.$this->table.' SET ';
			for ($i=0;$i<$this->col_num-1;$i++)
				$sql.=$this->col[$i].' = ? ,';
			$sql.=$this->col[$this->col_num-1].' = ? ';
			$sql.='WHERE ';
			$sql=$this->where_generate($sql);
			return $sql;
		}
		//delete logic
		if ($this->type=='d')
		{
			$sql='DELETE FROM '.$this->table.' WHERE ';
			$sql=$this->where_generate($sql);
			return $sql;
		}

		if ($this->type=='c')
		{
			$sql='SELECT COUNT (';
			if ($this->col_num==0)
			{
				$this->flag['all']=true;
				$sql.='*) FROM '.$this->table;
			}
			else 
			{
				$sql.=$this->col[0].') ';
				$sql.='FROM '.$this->table;
			}
			if ($this->query_num>0)
			{
				$sql.=' WHERE ';
				$sql=$this->where_generate($sql);
			}
			return $sql;

		}
	}

	public function get_params()
	{
		if ($this->or_where){
			// return 1;
			$type='';
			foreach ($this->orValue as $valueArr){
				foreach ($valueArr as $value){
					switch (gettype($value))
					{
						case 'string':$type.='s';break;
						case 'integer':$type.='i';break;
						case 'double':$type.='d';break;
					}
				}
			}
			$key=array_keys($this->orValue);
			$param=$this->orValue[$key[0]];
			for ($i=1;$i<$this->orNum;$i++)
				if ($key[$i]!='all')
				$param=array_merge($param, $this->orValue[$key[$i]]);
			array_unshift($param, $type);
			// $param['status']=1;
			return $param;
		}
		$type='';
		$values = array_merge($this->values,$this->not_value);
		foreach ($values as $value)
			switch (gettype($value))
			 {
				case 'string':$type.='s';break;
				case 'integer':$type.='i';break;
				case 'double':$type.='d';break;
			}
		$param=$values;
		array_unshift($param, $type);
		return $param;
	}

	public function get_update_params()
	{
		$type='';
		foreach ($this->col_values as $value)
			switch (gettype($value))
			 {
				case 'string':$type.='s';break;
				case 'integer':$type.='i';break;
				case 'double':$type.='d';break;
			}
		foreach ($this->values as $value) 
			switch (gettype($value))
			 {
				case 'string':$type.='s';break;
				case 'integer':$type.='i';break;
				case 'double':$type.='d';break;
			}
		$param=array_merge($this->col_values,$this->values);
		array_unshift($param, $type);
		return $param;
	}
}

?>