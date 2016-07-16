<?php
include 'model.php';

$sql=new SQL();
$sql->table='test';
$sql->type='s';
echo $sql->add('col_1','1');
print_r($sql->get_case());


?>