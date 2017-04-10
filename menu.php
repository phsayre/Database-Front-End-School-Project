<?php require_once('Connections/zhandyman.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
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
}

mysql_select_db($database_zhandyman, $zhandyman);
$query_customerMaster = "SELECT * FROM customer ORDER BY c_name ASC";
$customerMaster = mysql_query($query_customerMaster, $zhandyman) or die(mysql_error());
$row_customerMaster = mysql_fetch_assoc($customerMaster);
$totalRows_customerMaster = mysql_num_rows($customerMaster);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>menu</title>
</head>

<body>
| 
<a href="allCustomer.php">Customers</a> | <a href="allTask.php">Tasks</a> | <a href="allWorkers.php">Workers</a> | <a href="allJobs.php">Jobs</a> | <a href="allJobsProfit.php">Profit</a> | <a href="allAbout.php">About</a> | <a href="allMore1.php">more1</a> | <a href="allMore2.php">more2</a> |
</body>
</html>
<?php
mysql_free_result($customerMaster);
?>
