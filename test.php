<?php
include 'model.php';

$sql=new SQL();
$sql->table='test';
$sql->type='s';
$sql->add('col_1','17546534543');
echo $sql->generate();
print_r($sql->get_values());


?>