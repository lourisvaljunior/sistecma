<?php require_once('Connections/MyConnection.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password=$_POST['senha'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "administracao.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_MyConnection, $MyConnection);
  
  $LoginRS__query=sprintf("SELECT usuario, senha FROM usuarios WHERE usuario='%s' AND senha='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $MyConnection) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8" />
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon"/>
<link rel="stylesheet" href="styles/index.css">
<title>MASolu&ccedil;&otilde;es Oficial</title>
<meta name="viewport" content="width=device-width, initial-scale=1">  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div id="container">

<div id="login">
<div id="logo"></div>
<div id="cadastro">
	<div class="form-group">
  <form METHOD="POST" action="<?php echo $loginFormAction; ?>" name="loginAdmin">
    <p>&nbsp;</p>
    <p>
    </p>
    <p>
      <input type="text" class="form-control form-control-lg" autocomplete="off" placeholder="usuário" name="usuario" required>
      <br>
    </p>
    <p>
      <input type="password" class="form-control form-control-lg" placeholder="senha" name="senha" id="senha" required="required">
    </p>
    <p>
      <input type="checkbox" onclick="show()"> Mostrar caracteres
    </p>

<button type="submit" class="btn btn-primary btn-lg btn-block">ENTRAR</button>
<p>&nbsp;</p>
<p>&nbsp;</p>
  </form>
  </div>
    <a href="passwordreset.php">Esqueceu sua senha?</a></div>  
  </div>

<div id="image"></div>
</div>
<!-- Script do checkbox para mostrar a senha do campo password -->
<script>                        
function show() {
  var senha = document.getElementById("senha");
  if (senha.type === "password") {
    senha.type = "text";
  } else {
    senha.type = "password";
  }
}
</script>
</body>
</html>