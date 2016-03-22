<?php
/*
*根据客户端提交的菜品的序号，分页返回后续的5条菜品
*有main.html调用
*/
header('Content-Type: application/json');
$output=[];
$count=5;//一次最多返回的记录条数
@$start = $_REQUEST['start'];//客户端提交的起始记录
 //@符号压制改行代码产生的错误信息或警告信息
if( empty($start)){
    $start= 0 ;
}
/*第一页： 从0条开始取5条
    第二页从5条开始取5条
    第三页从10开始取5条
*/
//访问数据库
$conn= mysqli_connect('127.0.0.1','root','','kaifanla','3306');
$sql = 'SET NAMES UTF8';
mysqli_query($conn,$sql);
$sql="SELECT did,name,img_sm,material,price FROM kf_dish LIMIT $start,$count";
$result=mysqli_query($conn,$sql);
while(($row=mysqli_fetch_array($result))!==Null ){
    $output[]=$row;
}

echo json_encode($output);

?>