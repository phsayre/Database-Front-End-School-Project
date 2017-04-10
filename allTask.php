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

$maxRows_task = 10;
$pageNum_task = 0;
if (isset($_GET['pageNum_task'])) {
  $pageNum_task = $_GET['pageNum_task'];
}
$startRow_task = $pageNum_task * $maxRows_task;

mysql_select_db($database_zhandyman, $zhandyman);
$query_task = "SELECT * FROM task";
$query_limit_task = sprintf("%s LIMIT %d, %d", $query_task, $startRow_task, $maxRows_task);
$task = mysql_query($query_limit_task, $zhandyman) or die(mysql_error());
$row_task = mysql_fetch_assoc($task);

if (isset($_GET['totalRows_task'])) {
  $totalRows_task = $_GET['totalRows_task'];
} else {
  $all_task = mysql_query($query_task);
  $totalRows_task = mysql_num_rows($all_task);
}
$totalPages_task = ceil($totalRows_task/$maxRows_task)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>All Tasks</title>
</head>

<body>
<p>All Tasks</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table border="1">
  <tr>
    <td>t_id</td>
    <td>t_name</td>
    <td>t_cost</td>
    <td>t_memo</td>
    <td>t_In_door_Out_door_IO</td>
    <td>t_season_SMFW</td>
    <td>t_memo2</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_task['t_id']; ?></td>
      <td><?php echo $row_task['t_name']; ?></td>
      <td><?php echo $row_task['t_cost']; ?></td>
      <td><?php echo $row_task['t_memo']; ?></td>
      <td><?php echo $row_task['t_In_door_Out_door_IO']; ?></td>
      <td><?php echo $row_task['t_season_SMFW']; ?></td>
      <td><?php echo $row_task['t_memo2']; ?></td>
    </tr>
    <?php } while ($row_task = mysql_fetch_assoc($task)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($task);
?>
