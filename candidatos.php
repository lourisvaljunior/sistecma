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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO candidatos (id_candidato, chapa, numero, foto) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_candidato'], "int"),
                       GetSQLValueString($_POST['chapa'], "text"),
                       GetSQLValueString($_POST['numero'], "int"),
                       GetSQLValueString($_POST['foto'], "text"));

  mysql_select_db($database_MyConnection, $MyConnection);
  $Result1 = mysql_query($insertSQL, $MyConnection) or die(mysql_error());

  $insertGoTo = "candidatos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_MyConnection, $MyConnection);
$query_lista = "SELECT * FROM candidatos ORDER BY chapa ASC";
$lista = mysql_query($query_lista, $MyConnection) or die(mysql_error());
$row_lista = mysql_fetch_assoc($lista);
$totalRows_lista = mysql_num_rows($lista);
$query_lista = "SELECT * FROM candidatos ORDER BY chapa ASC";
$lista = mysql_query($query_lista, $MyConnection) or die(mysql_error());
$row_lista = mysql_fetch_assoc($lista);
$totalRows_lista = mysql_num_rows($lista);
?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon"/>
	<link rel="stylesheet" href="styles/candidatos.css">
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

<title>Candidatos</title>
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
    <li class="nav-item">
      <a href="limpar_tcandidatos.php?id_candidato=<?php echo $row_lista['id_candidato']; ?>" class="nav-link" ><i class="material-icons" style="color:red">clear_all</i> Limpar Candidatos</a>
  </ul>
</nav>
	<div class="topnav-right">
    	<a href="<?php echo $logoutAction ?>"><i class="material-icons" style="font-size:25px;color:red">exit_to_app</i></a>  	</div>
<br>
  
<div id="container">
		<div id="cad_cand">
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table align="center">
              <tr valign="baseline">
                <td nowrap align="right">ID:</td>
                <td><input type="text" name="id_candidato" class="form-control form-control" value="" size="32" disabled="disabled"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">CANDIDATO:</td>
                <td><input type="text" name="chapa" style="text-transform:uppercase" autocomplete="off" class="form-control form-control" placeholder="CHAPA" value="" size="32" required></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">NÚMERO:</td>
                <td><input type="text" name="numero" autocomplete="off" class="form-control form-control" placeholder="NÚMERO" value="" size="32" required></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">FOTO</td>
                <td><input type="file" name="foto" value="" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">&nbsp;</td>
                <td><input type="submit" class="btn btn-secondary" value="Cadastrar"></td>
              </tr>
            </table>
            <input type="hidden" name="MM_insert" value="form1">
          </form>
          <p>&nbsp;</p>
		</div>
  <div id="lista">
    <table class="table table-dark table-striped">
      <tr>
        <td align="left"><strong>#</strong></td>
        <td align="left"><strong>CHAPA</strong></td>
        <td align="left"><strong>NÚMERO</strong></td>
        <td align="center"><strong>FOTO</strong></td>
        <td align="center"><i class="fa fa-trash"></i></td>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_lista['id_candidato']; ?></td>
          <td><?php echo $row_lista['chapa']; ?></td>
          <td><?php echo $row_lista['numero']; ?></td>
          <td><img src="upload/<?php echo $row_lista['foto']; ?>"/></td>
          <td><a href="excluir_candidato.php?id_candidato=<?php echo $row_lista['id_candidato']; ?>"><i class="fa fa-user-times"></i></a></td>
        </tr>
        <?php } while ($row_lista = mysql_fetch_assoc($lista)); ?>
    </table>
  </div>
  
</div>		
    
<div class="footer">
  <p>Desenvolvedor: Professor Júnior</p>
</div>
	
</body>
</html>
<?php
mysql_free_result($lista);
?>
