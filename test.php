<?php
include 'model.php';

$sql=new SQL();
$sql->table='test';
$sql->type='s';
$sql->add('col_1','1');
print_r(mysqli_select($sql));
?>