<?php
header('Access-Control-Allow-Origin: *');
include 'model.php';

if (isset($GLOBALS['HTTP_RAW_POST_DATA'])){
    $data = $GLOBALS['HTTP_RAW_POST_DATA'];
    $data = json_decode($data);
    $ins=$data->ins;
    if ($ins=='login'){
        login($data);
    }
    if ($ins=='signup'){
        signup($data);
    }
    if ($ins=='add'){
        add($data);
    }
    if ($ins=='edit'){
        edit($data);
    }
    if ($ins=='delete'){
        delete($data);
    }
    if ($ins=="select"){
        select($data);
    }
}

function login($data){
    $usn = $data->name;
    $psw = $data->password;
    if ($usn=='admin'&&$psw=='123'){
        $response['status']=1;
        $response['type']='admin';
    } else {
        $response['status']=0;
    }
    echo json_encode($response);
}

function signup($data){

}

function add($data){
    $table=$data->table;
    $addData=(array)$data->data;
    $keys=array_keys($addData);
    $sql = new SQL();
    $sql->type = 'i';
    $sql->table = $table;

    for ($i=0;$i<count($keys);$i++){
        $sql->add($keys[$i],$addData[$keys[$i]]);
    }

    $result = mysqli_run($sql);
    if (is_numeric($result)){
        $response['status']=1;
        $response['data']=$result;
        echo json_encode($response);
    } else {
        $response['status']=0;
        $response['err']=$result;
        echo json_encode($response);
    }
}

function edit($data){
    $table = $data->table;
    $sql = new SQL();
    $sql->type = 'u';
    $sql->table = $table;
    $sql->add('id',$data->id);

    $updateData =(array) $data->data;
    $key = array_keys($updateData);
    for ($i=0;$i<count($key);$i++){
        $sql->add_update_col($key[$i],$updateData[$key[$i]]);
    }

    $result = mysqli_run($sql);
    if (is_numeric($result)){
        $response['status']=1;
        $response['data']=$result;
        echo json_encode($response);
    } else {
        $response['status']=0;
        $response['err']=$result;
        echo json_encode($response);
    }
}

function delete($data){
    $table = $data->table;
    $sql = new SQL();
    $sql->type = 'd';
    $sql->table = $table;
    $sql->add('id',$data->id);
    $result = mysqli_run($sql);
    if (is_numeric($result)){
        $response['status']=1;
        $response['data']=$result;
        echo json_encode($response);
    } else {
        $response['status']=0;
        $response['err']=$result;
        echo json_encode($response);
    }
}

function select($data){
    $table = $data->table;
    $sql = new SQL();
    $sql->type = 's';
    $sql->table = $table;
    if ($data->option->all){
        $sql->add(1,1);
        $result = mysqli_run($sql);
        $response['status']=1;
        $response['data']=$result;
        echo json_encode($response);
        return ;
    } else {
        $option = (array)$data->option;
        $n=count($option);
        $key = array_keys($option);
        for ($i=0;$i<$n;$i++){
            if ($key[$i]!='all')
                $sql->add_or($key[$i],$option[$key[$i]]);
        }
        $result = mysqli_run($sql);
        $response['status']=1;
        $response['data']=$result;
        echo json_encode($response);
        return ;
    }
}

?>