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

$maxRows_customer = 10;
$pageNum_customer = 0;
if (isset($_GET['pageNum_customer'])) {
  $pageNum_customer = $_GET['pageNum_customer'];
}
$startRow_customer = $pageNum_customer * $maxRows_customer;

mysql_select_db($database_zhandyman, $zhandyman);
$query_customer = "SELECT * FROM customer";
$query_limit_customer = sprintf("%s LIMIT %d, %d", $query_customer, $startRow_customer, $maxRows_customer);
$customer = mysql_query($query_limit_customer, $zhandyman) or die(mysql_error());
$row_customer = mysql_fetch_assoc($customer);

if (isset($_GET['totalRows_customer'])) {
  $totalRows_customer = $_GET['totalRows_customer'];
} else {
  $all_customer = mysql_query($query_customer);
  $totalRows_customer = mysql_num_rows($all_customer);
}
$totalPages_customer = ceil($totalRows_customer/$maxRows_customer)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>All Customers</title>
</head>

<body>
<p>All Customers</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table border="1">
  <tr>
    <td>c_id</td>
    <td>c_name</td>
    <td>c_address</td>
    <td>c_user</td>
    <td>c_catagory</td>
    <td>c_location</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_customer['c_id']; ?></td>
      <td><?php echo $row_customer['c_name']; ?></td>
      <td><?php echo $row_customer['c_address']; ?></td>
      <td><?php echo $row_customer['c_user']; ?></td>
      <td><?php echo $row_customer['c_catagory']; ?></td>
      <td><?php echo $row_customer['c_location']; ?></td>
    </tr>
    <?php } while ($row_customer = mysql_fetch_assoc($customer)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($customer);
?>
