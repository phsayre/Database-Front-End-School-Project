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

$maxRows_worker = 10;
$pageNum_worker = 0;
if (isset($_GET['pageNum_worker'])) {
  $pageNum_worker = $_GET['pageNum_worker'];
}
$startRow_worker = $pageNum_worker * $maxRows_worker;

mysql_select_db($database_zhandyman, $zhandyman);
$query_worker = "SELECT * FROM worker";
$query_limit_worker = sprintf("%s LIMIT %d, %d", $query_worker, $startRow_worker, $maxRows_worker);
$worker = mysql_query($query_limit_worker, $zhandyman) or die(mysql_error());
$row_worker = mysql_fetch_assoc($worker);

if (isset($_GET['totalRows_worker'])) {
  $totalRows_worker = $_GET['totalRows_worker'];
} else {
  $all_worker = mysql_query($query_worker);
  $totalRows_worker = mysql_num_rows($all_worker);
}
$totalPages_worker = ceil($totalRows_worker/$maxRows_worker)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>All Workers</title>
</head>

<body>
<p>All Workers</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table border="1">
  <tr>
    <td>w_id</td>
    <td>w_name</td>
    <td>w_rate</td>
    <td>w_user</td>
    <td>w_age_group</td>
    <td>w_gender</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_worker['w_id']; ?></td>
      <td><?php echo $row_worker['w_name']; ?></td>
      <td><?php echo $row_worker['w_rate']; ?></td>
      <td><?php echo $row_worker['w_user']; ?></td>
      <td><?php echo $row_worker['w_age_group']; ?></td>
      <td><?php echo $row_worker['w_gender']; ?></td>
    </tr>
    <?php } while ($row_worker = mysql_fetch_assoc($worker)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($worker);
?>
