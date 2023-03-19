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
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon"/>
	<link rel="stylesheet" href="styles/contato.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<!-- Link para os �cones dos menus-->
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Link para os �cones dos menus-->
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
	<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
	<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<title>Contato</title></head>
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
    	<a href="<?php echo $logoutAction ?>"><i class="material-icons" style="font-size:25px;color:red">exit_to_app</i></a>  	</div>
        
<br>

<?
 if (isset($_POST['enviar']) && $_POST['enviar']) {

  $header1 = 'From: '.$_POST['email'];

 if (mail('lourisvaljunior@gmail.com', 'Mensagem de '.$_POST['nome'], $_POST['msg'], $header1))
  $_POST['ok']='Mensagem enviada com sucesso'; else $_POST['ok']='Ocorreu algum problema'; 
}
?>

<div id="container">

<div id="texto">Conte-nos o que achou do sistema.</div>

<div id="formulario">
<div class="form-group">
<form name="form1" method="post" action="">
  <p>&nbsp;</p>
      <p><span id="sprytextfield2">
        <input name="nome" type="text" autocomplete="off" class="form-control" id="nome" placeholder="nome" required />
        <span class="textfieldRequiredMsg"></span></span></p>
      <p><span id="sprytextfield3">
      <input name="email" type="text" autocomplete="off" class="form-control" id="email2" placeholder="e-mail" required />
      <span class="textfieldRequiredMsg"></span><span class="textfieldInvalidFormatMsg">Formato inválido.</span></span></p>
      <p>
        <input name="ok" type="hidden" id="ok" value="<?$_POST['ok'];?>"> 
        <label for="telefone"></label>
        <span id="sprytextfield1">
          <input name="telefone" type="text" autocomplete="off" class="form-control" id="telefone" placeholder="telefone com o DDD" required />
          <span class="textfieldInvalidFormatMsg"></span></span>
        </p>
      </p>
      <p><span id="sprytextarea1">
        <textarea name="msg" rows="5" class="form-control" id="textarea" placeholder="Mensagem de no máximo 500 caracteres" ></textarea>
        <span id="countsprytextarea1">&nbsp;</span><span class="textareaRequiredMsg"></span><span class="textareaMaxCharsMsg"></span></span></p>
      <p>
        <input name="enviar" type="submit" class="btn btn-primary btn-lg" id="enviar" value="Enviar" />
      </p>
      </tr>
  </table>
</form>
</div>
</div>

</div>

<?
 if (isset($_POST['ok']) && $_POST['ok']) echo '<script language="javascript">alert("'.$_POST['ok'].'"); </script>';
?>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "phone_number", {isRequired:false, useCharacterMasking:true, format:"phone_custom", pattern:"(00) 0000-0000", hint:"(00) 0000-0000"});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {maxChars:500, counterId:"countsprytextarea1", counterType:"chars_count"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email");
</script>
</body>
</html>
