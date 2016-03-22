<?php
/*
*根据客户端提交的菜品的序号，分页返回后续的5条菜品
*有main.html调用
*/
header('Content-Type: application/json');
$output = [];
@$did = $_REQUEST['did'];
if(empty($did)){
    echo"[]";
    return;
}

 //@符号压制改行代码产生的错误信息或警告信息


//访问数据库
$conn= mysqli_connect('127.0.0.1','root','','kaifanla','3306');
$sql = 'SET NAMES UTF8';
mysqli_query($conn,$sql);
$sql="SELECT did,name,img_lg,material,detail,price FROM kf_dish WHERE did=$did";
$result=mysqli_query($conn,$sql);
if( ($row=mysqli_fetch_array($result))!==Null ){
    $output[]=$row;
}

echo json_encode($output);

?>