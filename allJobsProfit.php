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
$query_jobAndProfit = "SELECT  c_name, w_name, t_name, t_cost, w_rate, j_hours, (j_hours * t_cost) AS BillCust, (j_hours * w_rate) AS PayWork, ((j_hours * t_cost) - (j_hours * w_rate)) AS PROFIT FROM job, customer, worker, task WHERE job.c_id = customer.c_id and job.w_id = worker.w_id";
$jobAndProfit = mysql_query($query_jobAndProfit, $zhandyman) or die(mysql_error());
$row_jobAndProfit = mysql_fetch_assoc($jobAndProfit);
$totalRows_jobAndProfit = mysql_num_rows($jobAndProfit);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>All Jobs and Profit</title>
</head>

<body>
<p>All Jobs and Profit</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table border="1">
  <tr>
    <td>c_name</td>
    <td>w_name</td>
    <td>t_name</td>
    <td>t_cost</td>
    <td>w_rate</td>
    <td>j_hours</td>
    <td>BillCust</td>
    <td>PayWork</td>
    <td>PROFIT</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_jobAndProfit['c_name']; ?></td>
      <td><?php echo $row_jobAndProfit['w_name']; ?></td>
      <td><?php echo $row_jobAndProfit['t_name']; ?></td>
      <td><?php echo $row_jobAndProfit['t_cost']; ?></td>
      <td><?php echo $row_jobAndProfit['w_rate']; ?></td>
      <td><?php echo $row_jobAndProfit['j_hours']; ?></td>
      <td><?php echo $row_jobAndProfit['BillCust']; ?></td>
      <td><?php echo $row_jobAndProfit['PayWork']; ?></td>
      <td><?php echo $row_jobAndProfit['PROFIT']; ?></td>
    </tr>
    <?php } while ($row_jobAndProfit = mysql_fetch_assoc($jobAndProfit)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($jobAndProfit);
?>
