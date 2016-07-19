<?php
include 'model.php';

$sql=new SQL();
$sql->table='test';
$sql->type='c';
$sql->add_col('col');
$sql->add_col('col_2');
$sql->add('col_1','1');
$sql->add('col_2',2);
echo $sql->generate();
?>