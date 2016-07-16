<?php
include 'model.php';

$sql=new SQL();
$sql->table='test';
$sql->type='s';
$sql->add('col_1','1');
echo $sql->generate();


?>