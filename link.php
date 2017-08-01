<?php

function link_db($mysqli)//link data base and set utf-8
{
	$mysqli->connect('localhost','root','','cloth');
	$mysqli->set_charset('UTF8');
}
?>