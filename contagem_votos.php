<?php require_once('Connections/MyConnection.php'); ?>
<?php require_once('Connections/MyConnection.php'); ?>
<?php require_once('Connections/MyConnection.php'); ?>
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

$colname_Busca = "-1";
if (isset($_POST['chapa'])) {
  $colname_Busca = $_POST['chapa'];
}
mysql_select_db($database_MyConnection, $MyConnection);
$query_Busca = sprintf("SELECT * FROM votacao WHERE chapa = %s ORDER BY chapa ASC", GetSQLValueString($colname_Busca, "text"));
$Busca = mysql_query($query_Busca, $MyConnection) or die(mysql_error());
$row_Busca = mysql_fetch_assoc($Busca);
$totalRows_Busca = mysql_num_rows($Busca);

mysql_select_db($database_MyConnection, $MyConnection);
$query_QntVotos = "SELECT chapa, COUNT(chapa) AS Qtd FROM votacao GROUP BY chapa ORDER BY COUNT(chapa) ASC";
$QntVotos = mysql_query($query_QntVotos, $MyConnection) or die(mysql_error());
$row_QntVotos = mysql_fetch_assoc($QntVotos);
$totalRows_QntVotos = mysql_num_rows($QntVotos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="370" align="center">
  <tr>
    <th width="360" scope="col"><form id="form1" name="form1" method="post" action="">
CANDIDATO:
      <label for="chapa"></label>
      <input type="text" name="chapa" id="chapa" />
      <input type="submit" name="button" id="button" value="BUSCAR" />
    </form></th>
  </tr>
</table>
<p>&nbsp;</p>
<table border="1" align="center">
  <tr>
    <td>id_votos</td>
    <td>chapa</td>
    <td>numero</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Busca['id_votos']; ?></td>
      <td><?php echo $row_Busca['chapa']; ?></td>
      <td><?php echo $row_Busca['numero']; ?></td>
    </tr>
    <?php } while ($row_Busca = mysql_fetch_assoc($Busca)); ?>
</table>
<p><strong>SOMA DOS VOTOS </strong></p>
<p>&nbsp;</p>
<table border="1" align="center">
  <tr>
    <td>chapa</td>
    <td>Qtd</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_QntVotos['chapa']; ?></td>
      <td><?php echo $row_QntVotos['Qtd']; ?></td>
    </tr>
    <?php } while ($row_QntVotos = mysql_fetch_assoc($QntVotos)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($Busca);

mysql_free_result($QntVotos);
?>
