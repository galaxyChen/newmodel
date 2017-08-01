<?php
header('Access-Control-Allow-Origin: *');
include 'model.php';

if (isset($GLOBALS['HTTP_RAW_POST_DATA'])){
    $data = $GLOBALS['HTTP_RAW_POST_DATA'];
    $data = json_decode($data);
    $sql = new SQL();
    
    echo var_dump($data);
}


?>