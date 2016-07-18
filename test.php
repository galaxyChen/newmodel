<?php
include 'model.php';

$sql=new SQL();
$sql->table='test';
$sql->type='u';
$sql->add_update_col('col_1','1');
$sql->add('id','1');
echo mysqli_run($sql);
?>