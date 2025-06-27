<?php header('Access-Control-Allow-Origin: *');
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
require "testmed.php";
$res=$_GET['vopros'];
$sql="select * from `accred` where `accred`.vopros like '%$res%' ";
//echo $sql;
$Result1 = DB::Query($sql) or die(  mysqli_error(DB::$link));
$row_Recordset1 = mysqli_fetch_assoc($Result1);
$totalRows_Recordset1 = mysqli_num_rows($Result1);
if ($totalRows_Recordset1==0) {echo "0";exit;}
$sout=[];

//do{
    $sout['otv1']=$row_Recordset1['otv1'];
    $sout['otv2']=$row_Recordset1['otv2'];
    $sout['otv3']=$row_Recordset1['otv3'];
    $sout['otv4']=$row_Recordset1['otv4'];
 $sout['vopros']=$res;
  //  } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
echo json_encode($sout);
?>