<?php
include_once 'reader.php';
$tmp=$_FILES['file']['tmp_name'];
if (empty($tmp)){
    exit('选择要导入的文件');
}

$conn=mysqli_connect('localhost','root','','database','3306');

$save_path='xls/';
$file_name=$save_path.date('Ymdhis').'xls'; //上传后的文件保存路径和名称
if (copy($tmp,$file_name)){
    $xls=new Spreadsheet_Excel_Reader();
    $xls->setOutputEncoding('utf-8');
    $xls->read($file_name); //解析文件
    for ($i=2;$i<=$xls->sheets[0]['numRows'];$i++){
        $name=$xls->sheets[0]['cells'][$i][0];
        $sex=$xls->sheets[0]['cells'][$i][1];
        $age=$xls->sheets[0]['cells'][$i][2];
        $data_values.="('$name','$sex','$age'),";
    }
    $data_values=substr($data_values,0,-1); //去掉最后一个逗号
    $query=mysqli_query($conn,"insert into student(name,sex,age) values $data_values"); //批量插入数据表中
    if ($query){
        echo '导入成功';
    }else{
        echo '导入失败';
    }
}