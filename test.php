<?php
include 'model.php';

$sql=new SQL();
$sql->table='test';
$sql->type='s';
$string="1";
$sql->add('col_1',$string);
echo $sql->generate();
print_r($sql->get_values());


?>