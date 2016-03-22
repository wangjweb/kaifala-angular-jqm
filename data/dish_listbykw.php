<?php
/*

*/
header('Content-Type: application/json');
$output=[];

@$kw = $_REQUEST['kw'];
if(empty($kw)){
    echo"[]";
    return;
}

//
$conn= mysqli_connect('127.0.0.1','root','','kaifanla','3306');
$sql = 'SET NAMES UTF8';
mysqli_query($conn,$sql);
$sql="SELECT did,name,img_sm,material,price FROM kf_dish WHERE name LIKE  '%$kw%' OR material LIKE '%$kw%'";
$result=mysqli_query($conn,$sql);
while(($row=mysqli_fetch_array($result))!==Null ){
    $output[]=$row;
}


echo json_encode($output);

?>