<?php
include 'model.php';

$sql=new SQL();
$sql->table='test';
$sql->type='s';
echo $sql->generate();


?>