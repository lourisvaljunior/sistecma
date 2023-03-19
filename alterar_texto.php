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
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
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

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE eleicao_tipo SET eleicao=%s WHERE id_tipo=%s",
                       GetSQLValueString($_POST['eleicao'], "text"),
                       GetSQLValueString($_POST['id_tipo'], "int"));

  mysql_select_db($database_MyConnection, $MyConnection);
  $Result1 = mysql_query($updateSQL, $MyConnection) or die(mysql_error());

  $updateGoTo = "alterar_texto.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_RecordAlterTexto = 10;
$pageNum_RecordAlterTexto = 0;
if (isset($_GET['pageNum_RecordAlterTexto'])) {
  $pageNum_RecordAlterTexto = $_GET['pageNum_RecordAlterTexto'];
}
$startRow_RecordAlterTexto = $pageNum_RecordAlterTexto * $maxRows_RecordAlterTexto;

mysql_select_db($database_MyConnection, $MyConnection);
$query_RecordAlterTexto = "SELECT * FROM eleicao_tipo";
$query_limit_RecordAlterTexto = sprintf("%s LIMIT %d, %d", $query_RecordAlterTexto, $startRow_RecordAlterTexto, $maxRows_RecordAlterTexto);
$RecordAlterTexto = mysql_query($query_limit_RecordAlterTexto, $MyConnection) or die(mysql_error());
$row_RecordAlterTexto = mysql_fetch_assoc($RecordAlterTexto);

if (isset($_GET['totalRows_RecordAlterTexto'])) {
  $totalRows_RecordAlterTexto = $_GET['totalRows_RecordAlterTexto'];
} else {
  $all_RecordAlterTexto = mysql_query($query_RecordAlterTexto);
  $totalRows_RecordAlterTexto = mysql_num_rows($all_RecordAlterTexto);
}
$totalPages_RecordAlterTexto = ceil($totalRows_RecordAlterTexto/$maxRows_RecordAlterTexto)-1;
?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon"/>
	<link rel="stylesheet" href="styles/alter_texto.css">
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

<title>Alterar Texto</title>
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
  </ul>
</nav>
	<div class="topnav-right">
    	<a href="<?php echo $logoutAction ?>"><i class="material-icons" style="font-size:25px;color:red">exit_to_app</i></a> 
    </div>
<br>

<div id="container">
		<div id="alt_texto">
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table align="center">
              <tr valign="baseline">
                <td nowrap align="right"><strong>DESCRIÇÃO:</strong></td>
                <td><input type="text" name="eleicao" autocomplete="off" class="form-control form-control-sm" placeholder="DESCRIÇÃO" value="<?php echo $row_RecordAlterTexto['eleicao']; ?>" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">&nbsp;</td>
                <td><input type="submit" class="btn btn-secondary" value="Alterar Descrição"></td>
              </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1">
            <input type="hidden" name="id_tipo" value="<?php echo $row_RecordAlterTexto['id_tipo']; ?>">
          </form>
          <p>&nbsp;</p>
		</div>
		<div id="listagem">
          <table class="table table-dark table-striped">
		  	<thead>
            <tr>
              <td><div align="left"><strong>#</strong></div></td>
              <td><div align="left"><strong>DESCRIÇÃO</strong></div></td>
            </tr>
			</thead>
            <?php do { ?>
              <tr>
                <td><?php echo $row_RecordAlterTexto['id_tipo']; ?></td>
                <td><?php echo $row_RecordAlterTexto['eleicao']; ?></td>
              </tr>
              <?php } while ($row_RecordAlterTexto = mysql_fetch_assoc($RecordAlterTexto)); ?>
          </table>
		</div>
</div> 
      
<div class="footer">
  <p>Desenvolvedor: Professor Júnior</p>
</div>
	
</body>
</html>
<?php
mysql_free_result($RecordAlterTexto);
?>