<?php
/*
*根据客户端提交的菜品的序号，分页返回后续的5条菜品
*有main.html调用
*/
header('Content-Type: application/json');
$output = [];

@$phone = $_REQUEST['phone'];
if(empty($phone)){
    echo"[]";
    return;
}

 //@符号压制改行代码产生的错误信息或警告信息


//访问数据库
$conn= mysqli_connect('127.0.0.1','root','','kaifanla','3306');
$sql = 'SET NAMES UTF8';
mysqli_query($conn,$sql);
$sql="SELECT kf_order.oid,kf_order.user_name,kf_order.order_time,kf_dish.img_sm FROM kf_order,kf_dish WHERE kf_order.did=kf_dish.did AND kf_order.phone='$phone'";
$result=mysqli_query($conn,$sql);
while( ($row=mysqli_fetch_array($result))!==Null ){
    $output[]=$row;
}

echo json_encode($output);

?>