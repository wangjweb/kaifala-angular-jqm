<?php
/*
*由main.html调用
*根据客户端提交的查询关键字，返回菜名或原料中包含指定关键字的菜品
*/
header('Content-Type: application/json');
$output=[];

@$oid = $_REQUEST['oid'];
if(empty($oid)){
    echo"[]";
    return;
}

//访问数据库
$conn= mysqli_connect('127.0.0.1','root','','kaifanla','3306');
$sql = 'SET NAMES UTF8';
mysqli_query($conn,$sql);
$sql="DELETE FROM kf_order WHERE oid= '$oid'" ;
$result=mysqli_query($conn,$sql);

if($result){    //INSERT语句执行成功
    $output['msg'] = 'succ';
}else{          //INSERT语句执行失败
    $output['msg'] = 'err';
}

echo json_encode($output);
?>