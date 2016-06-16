<?php
include 'link.php';


function mysql_select($sql)//where multuple where limit order
{
	$mysqli=new mysqli();
	link_db($mysqli);
	$mysqli->set_charset('UTF8');
	
}



?>