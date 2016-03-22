<?php
/*
*由main.html调用
*根据客户端提交的查询关键字，返回菜名或原料中包含指定关键字的菜品
*/
header('Content-Type: application/json');
$output=[];

@$user_name = $_REQUEST['user_name'];
@$phone = $_REQUEST['phone'];
@$sex = $_REQUEST['sex'];
@$did = $_REQUEST['did'];
@$addr = $_REQUEST['addr'];
$order_time = time()*1000;

if(empty($phone) || empty($user_name) || empty($sex) || empty($addr) || empty($did) ){
    echo "[]"; //若客户端提交信息不足，则返回一个空数组，
    return;    //并退出当前页面的执行
}

//访问数据库
$conn= mysqli_connect('127.0.0.1','root','','kaifanla','3306');
$sql = 'SET NAMES UTF8';
mysqli_query($conn,$sql);
$sql="INSERT INTO kf_order VALUES(NULL,'$phone','$user_name','$sex','$order_time','$addr','$did')" ;
$result=mysqli_query($conn,$sql);
$arr = [];
if($result){    //INSERT语句执行成功
    $arr['msg'] = 'succ';
    $arr['did'] = mysqli_insert_id($conn); //获取最近执行的一条INSERT语句生成的自增主键
}else{          //INSERT语句执行失败
    $arr['msg'] = 'err';
    $arr['reason'] = "SQL语句执行失败：$sql";
}
$output[] = $arr;
echo json_encode($output);
?>