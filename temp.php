<?php
include 'link.php';
include 'sql.php';


function execute($mysqli_stmt)
{
	if ($mysqli_stmt->execute())//return result
		{
			$mysqli_result=$mysqli_stmt->get_result();
			$result=array();
			$result=$mysqli_result->fetch_all(MYSQLI_ASSOC);
			$mysqli_stmt->close();
			$mysqli_result->free();
			return $result;
		}
		else return $mysqli_stmt->error;
}

/*
 parameter:$sql is an object
including case, values (array) to indicate the query 
including some methods to generate the query data
*/
function mysqli_select($sql)//where multuple where limit order
{
	$mysqli=new mysqli();
	link_db($mysqli);//link data base and set utf-8
	$prepare=$sql->generate();//generate a sql query string with ?
	$flag=$sql->get_flag();
	if (isset($flag['all']) && $flag['all'])//no ?,execute query directly
	{
		$mysqli_result=$mysqli->query($prepare);
		if ($mysqli_result && $mysqli_result->num_rows>0)
		{
			$result=array();
			$result=$mysqli_result->fetch_all(MYSQLI_ASSOC);
			return $result;	
		}
		else return 1;
	}
	else //prepare sql query
	{
		$mysqli_stmt=$mysqli->prepare($prepare);
		//prepare parameters to be bond.change value to parameters
		$params=array();
		$a=$sql->get_params();
		$n=count($a);
		for ($i=0;$i<$n;$i++)
		$params[$i]=&$a[$i];
		call_user_func_array(array($mysqli_stmt,'bind_param'),$params);
		
		$result=execute($mysqli_stmt);
		return $result;
	}
	$mysqli->close();
}


function mysqli_insert($sql)
{
	$mysqli=new mysqli();
	link_db($mysqli);
	$prepare=$sql->generate();
	$mysqli_stmt=$mysqli->prepare($prepare);
	//prepare bind parameters
	$params=array();
	$a=$sql->get_params();
	$n=count($a);
	for ($i=0;$i<$n;$i++)
		$params[$i]=&$a[$i];
	call_user_func_array(array($mysqli_stmt,'bind_param'),$params);
	
	if ($mysqli_stmt->execute())
		return $mysqli_stmt->insert_id;
	else return "error:".$mysqli_stmt->errno;
}

function mysqli_update($sql)
{
	$mysqli=new mysqli();
	link_db($mysqli);
	$prepare=$sql->generate();
	$mysqli_stmt=$mysqli->prepare($prepare);
	//prepare update parameters
	$params=array();
	$a=$sql->get_update_params();
	$n=count($a);
	for ($i=0;$i<$n;$i++)
		$params[$i]=&$a[$i];
	call_user_func_array(array($mysqli_stmt,'bind_param'),$params);
	

}

?>