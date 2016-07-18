<?php
include 'model.php';

$sql=new SQL();
$sql->table='test';
$sql->type='s';
$sql->add('col_1','1');
$sql->add_col('col_1');
echo $sql->generate();
print_r($sql->get_values());


?>