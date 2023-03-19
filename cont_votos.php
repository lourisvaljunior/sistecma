<?php require_once('Connections/MyConnection.php'); ?>
<?php require_once('Connections/MyConnection.php'); ?>
<?php require_once('Connections/MyConnection.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

mysql_select_db($database_MyConnection, $MyConnection);
$query_RecordsetResult = "SELECT * FROM votacao ORDER BY chapa DESC";
$RecordsetResult = mysql_query($query_RecordsetResult, $MyConnection) or die(mysql_error());
$row_RecordsetResult = mysql_fetch_assoc($RecordsetResult);
$totalRows_RecordsetResult = mysql_num_rows($RecordsetResult);

mysql_select_db($database_MyConnection, $MyConnection);
$query_ReultVotos = "SELECT chapa FROM votacao";
$ReultVotos = mysql_query($query_ReultVotos, $MyConnection) or die(mysql_error());
$row_ReultVotos = mysql_fetch_assoc($ReultVotos);
$totalRows_ReultVotos = mysql_num_rows($ReultVotos);

$maxRows_QuantVotos = 10;
$pageNum_QuantVotos = 0;
if (isset($_GET['pageNum_QuantVotos'])) {
  $pageNum_QuantVotos = $_GET['pageNum_QuantVotos'];
}
$startRow_QuantVotos = $pageNum_QuantVotos * $maxRows_QuantVotos;

mysql_select_db($database_MyConnection, $MyConnection);
$query_QuantVotos = "SELECT COUNT(*) AS chapa FROM votacao";
$query_limit_QuantVotos = sprintf("%s LIMIT %d, %d", $query_QuantVotos, $startRow_QuantVotos, $maxRows_QuantVotos);
$QuantVotos = mysql_query($query_limit_QuantVotos, $MyConnection) or die(mysql_error());
$row_QuantVotos = mysql_fetch_assoc($QuantVotos);

if (isset($_GET['totalRows_QuantVotos'])) {
  $totalRows_QuantVotos = $_GET['totalRows_QuantVotos'];
} else {
  $all_QuantVotos = mysql_query($query_QuantVotos);
  $totalRows_QuantVotos = mysql_num_rows($all_QuantVotos);
}
$totalPages_QuantVotos = ceil($totalRows_QuantVotos/$maxRows_QuantVotos)-1;

mysql_select_db($database_MyConnection, $MyConnection);
$query_ContVotos = "SELECT chapa, COUNT(chapa is null) AS Qtd FROM votacao GROUP BY chapa ORDER BY COUNT(chapa) DESC";
$ContVotos = mysql_query($query_ContVotos, $MyConnection) or die(mysql_error());
$row_ContVotos = mysql_fetch_assoc($ContVotos);
$totalRows_ContVotos = mysql_num_rows($ContVotos);
?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon"/>
	<link rel="stylesheet" href="styles/result.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Link para os ícones dos menus-->
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Link para os ícones dos menus-->
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
<title>Contagem Votos</title>
</head>
<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand -->
  <a href="tela_votacao.php" title="Liberar Votação" class="navbar-brand">UrnaEletrônica</a>

  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="administracao.php"><i class="fa fa-fw fa-home"></i>Home</a>    </li>
    <li class="nav-item">
      <a class="nav-link" href="contato.php"><i class="fa fa-fw fa-envelope"></i>Contato</a>    </li>
	
    <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
       <i class="fa fa-bars"></i>Cadastrar
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="alterar_texto.php"><i class="fa fa-file"></i>Texto</i></a>
		<a class="dropdown-item" href="cad_user.php"><i class="fa fa-user"></i>Usuário</i></a>
        <a class="dropdown-item" href="candidatos.php"><i class="fa fa-users"></i>Candidatos</a>
		<a class="dropdown-item" href="block.php"><i class="fa fa-key"></i>Bloqueio</a>
	  </div>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
      <i class="fa fa-files-o"></i>Resultados
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="resultado.php"><i class="fa fa-file-text"></i>Listagem</i></a>
		<a class="dropdown-item" href="cont_votos.php"><i class="fa fa-file-text-o"></i>Resumo</i></a>
	  </div>
    </li>
	<a class="nav-link" href="limpar_tbvotos.php?id=<?php echo $row_RecordsetResult['id_votos']; ?>&chapa=<?php echo $row_RecordsetResult['chapa']; ?>&numero=<?php echo $row_RecordsetResult['numero']; ?>"><i class="material-icons" style="color:red">clear_all</i> Limpar votação</a>
  </ul>
</nav>
	<div class="topnav-right">
    	<a href="<?php echo $logoutAction ?>"><i class="material-icons" style="font-size:25px;color:red">exit_to_app</i></a>  	</div>
<br>

<input type="button" class="btn btn-secondary" value="Criar PDF" id="btnImprimir" onClick="CriaPDF()" />

<div id="resultado">
<div id="quant_votos">
  <table align="left">
    <?php do { ?>
      <tr>
        <td align="left"><strong>Quantidade de votos:</strong><strong><?php echo $row_QuantVotos['chapa']; ?></strong></td>
      </tr>
      <?php } while ($row_QuantVotos = mysql_fetch_assoc($QuantVotos)); ?>
  </table>
</div>
<table class="table table-dark table-striped" align="center">
  <tr>
    <td>CANDIDATO/CHAPA</td>
    <td>VOTOS</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_ContVotos['chapa']; ?></td>
      <td><?php echo $row_ContVotos['Qtd']; ?></td>
    </tr>
    <?php } while ($row_ContVotos = mysql_fetch_assoc($ContVotos)); ?>
</table>
</div>
    
<div class="footer">
  <p>Desenvolvedor: Professor Júnior</p>
</div>

</body>
</html>

<script>
    function CriaPDF() {
        var minhaTabela = document.getElementById('resultado').innerHTML;

        var style = "<style>";
        style = style + "table {width: 100%;font: 20px Calibri;}";
        style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
        style = style + "padding: 2px 3px;text-align: left;}";
        style = style + "</style>";

        // CRIA UM OBJETO WINDOW
        var win = window.open('', '', 'height=700,width=700');

        win.document.write('<html><head>');
        win.document.write('<title>Resultado da Votação</title>');   // <title> CABEÇALHO DO PDF.
        win.document.write(style);                       // INCLUI UM ESTILO NA TAB HEAD
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write(minhaTabela);                   // O CONTEUDO DA TABELA DENTRO DA TAG BODY
        win.document.write('</body></html>');

        win.document.close(); 	                            // FECHA A JANELA

        win.print();                                        // IMPRIME O CONTEUDO
    }
</script>

<?php
mysql_free_result($RecordsetResult);

mysql_free_result($ReultVotos);

mysql_free_result($QuantVotos);

mysql_free_result($ContVotos);
?>