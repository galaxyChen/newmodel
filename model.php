<?php
include 'link.php';
$mysqli->set_charset('UTF8');

function mysql_select($sql)//where multuple where limit order
{
	print_r($mysqli);
}

function mysql_close()
{
	$mysqli->close();
}

?>