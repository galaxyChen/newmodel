<?php
include 'model.php';

$sql=new SQL();
$sql->table='test';
$sql->type='s';
echo $sql->add('col_1','1');
echo $sql->generate();
echo "\n";
echo $sql->get_num();


?>