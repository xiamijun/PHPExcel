<?php
$conn=mysqli_connect('localhost','root','','database','3306');

$result=mysqli_query($conn,"select * from student");

$str='姓名\t性别\t年龄\t\n';
$str=iconv('utf-8','gb2312',$str);
while ($row=mysqli_fetch_array($result)){
    $name=iconv('utf-8','gb2312',$row['name']);
    $sex=iconv('utf-8','gb2312',$row['sex']);
    $str.=$name.'\t'.$sex.'\t'.$row['age'].'\t\n';
}
$filename=date('Ymd').'.xls';
exportExcel($filename,$str);

function exportExcel($filename,$content){
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Content-Type:application/vnd.ms-excel');
    header("Content-Type: application/force-download");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment; filename=".$filename);
    header("Content-Transfer-Encoding: binary");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $content;
}