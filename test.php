<?php
include 'model.php';

$sql=new SQL();
$sql->table='test';
$sql->type='d';
$sql->add('col_1',111);
echo $sql->generate();
echo mysqli_run($sql);
?>