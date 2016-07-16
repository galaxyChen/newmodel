<?php
<<<<<<< HEAD
function link_db($mysqli)//link data base and set utf-8
{
	$mysqli->connect('localhost','root','root','test');
	$mysqli->set_charset('UTF8');
=======
function link_db($mysqli)
{
	$mysqli->connect('localhost','root','root','test');
>>>>>>> a00b2d064af2618b76c7d2c619319b1eb7fa6ebb
}
?>