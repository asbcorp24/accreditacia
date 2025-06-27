<?php require "testmed.php";

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
  //  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
/*
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tm_admin (`user`, pass) VALUES (%s, %s)",
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['pass'], "text"));


  $Result1 = DB::Query($insertSQL, $testmed) or die(  mysqli_error(DB::$link));
*/
if (isset($_FILES['file'])){
move_uploaded_file($_FILES['file']['tmp_name'], "test.csv");
  $s=  file_get_contents("test.csv");
    $s= mb_convert_encoding($s, "utf-8", "windows-1251");

   file_put_contents("test.csv",$s);
$row = 1;
if (($handle = fopen("test.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data);

        $row++;

      $sql="INSERT INTO `accred` (`id`, `vopros`, `otv1`, `otv2`, `otv3`, `otv4`) VALUES (NULL, '$data[1]', '$data[5]', '$data[6]', ' $data[7]', '$data[8]')";
        $Result1 = DB::Query($sql) or die(  mysqli_error(DB::$link));
    }
    fclose($handle);
}
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Документ без названия</title>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  файл с тестами
  <table>
  	<tr>
 <td></td><td> <input type="file" name="file" id="file" /></td>
 
  </tr>
  <tr>
 <td>Пароль</td><td>  <input type="password" name="pass" id="pass" /></td>

  </tr>
  <tr>
 <td></td><td> <input type="submit" name="button" id="button" value="Отправить" /></td>
 
  </tr>
  <tr>
 <td></td><td> <input type="submit" name="button" id="button" value="Отправить" /></td>
 
  </tr>
    </table>
</form>
</body>
</html>