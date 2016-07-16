<?php
include 'model.php';

$sql=new SQL();
$sql->table='test';
$sql->type='s';
$sql->add('col_1','175465345431111111111111');
echo $sql->generate();
print_r($sql->get_values());


?>