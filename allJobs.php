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

$maxRows_job = 10;
$pageNum_job = 0;
if (isset($_GET['pageNum_job'])) {
  $pageNum_job = $_GET['pageNum_job'];
}
$startRow_job = $pageNum_job * $maxRows_job;

mysql_select_db($database_zhandyman, $zhandyman);
$query_job = "SELECT * FROM job";
$query_limit_job = sprintf("%s LIMIT %d, %d", $query_job, $startRow_job, $maxRows_job);
$job = mysql_query($query_limit_job, $zhandyman) or die(mysql_error());
$row_job = mysql_fetch_assoc($job);

if (isset($_GET['totalRows_job'])) {
  $totalRows_job = $_GET['totalRows_job'];
} else {
  $all_job = mysql_query($query_job);
  $totalRows_job = mysql_num_rows($all_job);
}
$totalPages_job = ceil($totalRows_job/$maxRows_job)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>All Jobs</title>
</head>

<body>
<p>All Jobs</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table border="1">
  <tr>
    <td>j_id</td>
    <td>c_id</td>
    <td>w_id</td>
    <td>t_id</td>
    <td>j_date</td>
    <td>j_hours</td>
    <td>j_memo</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_job['j_id']; ?></td>
      <td><?php echo $row_job['c_id']; ?></td>
      <td><?php echo $row_job['w_id']; ?></td>
      <td><?php echo $row_job['t_id']; ?></td>
      <td><?php echo $row_job['j_date']; ?></td>
      <td><?php echo $row_job['j_hours']; ?></td>
      <td><?php echo $row_job['j_memo']; ?></td>
    </tr>
    <?php } while ($row_job = mysql_fetch_assoc($job)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($job);
?>
